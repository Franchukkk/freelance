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
            $project = Project::find($message->project_id);

            if (!isset($chats[$message->project_id])) {
                $chats[$message->project_id] = [
                    'project_title' => $project ? $project->title : 'Без назви',
                    'customer' => User::getById($message->receiver_id),
                    'freelancer' => User::getById($message->sender_id),
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
        $messages = Message::where('project_id', $request->post("project_id"))->get();
        $project_id = $request->post("project_id");
        $client_id = $request->post("client_id");
        return view('site/chat/show', compact('messages', 'project_id', 'client_id'));
    }

    /**
     * Store a new message
     *
     * @param Request $request
     * @return View
     */
    public function storeMessage(Request $request)
    {
        $data = [
            'project_id' => $request->post("project_id"),
            'sender_id' => auth()->id(),
            'receiver_id' => $request->post("receiver_id"),
            'message' => $request->post("message"),
        ];

        Message::create($data);
        return $this->showChat($request);
    }
}