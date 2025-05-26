<?php

namespace App\Http\Controllers\Site;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display a list of chats for a specific user
     *
     * @param int $user_id
     * @return View
     */
    public function index($user_id)
    {
        if (auth()->id() != $user_id) {
            abort(403);
        }

        $messages = Message::getMessagesByUserId($user_id);
        $chats = [];
        foreach ($messages as $message) {
            $project = Project::findOrFail($message->project_id);

            if (!isset($chats[$message->project_id])) {
                $chats[$message->project_id] = [
                    'project_title' => $project ? $project->title : 'Без назви',
                    'customer' => User::findOrFail($message->receiver_id),
                    'freelancer' => User::findOrFail($message->sender_id),
                ];
            }
        }

        return view('site/chat/index', compact('chats'));
    }

    /**
     * Display chat messages for a specific project
     *
     * @param Request $request
     * @return View
     */
    public function showChat(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:users,id',
            'freelancer_id' => 'required|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id'
        ]);

        $messages = Message::where('project_id', $validated['project_id'])->get();
        $project_id = $validated['project_id'];
        $client_id = $validated['client_id'] ?? $validated['receiver_id'];
        $freelancer_id = $validated['freelancer_id'];
        
        return view('site/chat/show', compact('messages', 'project_id', 'client_id', 'freelancer_id'));
    }

    /**
     * Store a new message
     *
     * @param Request $request
     * @return View
     */
    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $data = [
            'project_id' => $validated['project_id'],
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ];

        Message::create($data);
        return $this->showChat($request);
    }
}
