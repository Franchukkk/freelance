<?php

namespace App\Http\Controllers\Site;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($user_id)
    {
        if (auth()->id() != $user_id) {
            abort(403);
        }

        $chats = Message::getMessagesByUserId($user_id);

        $sortedChats = $chats->sortBy(function ($message) {
            return $message->created_at;
        })->groupBy('project_id');

        foreach ($sortedChats as $projectId => $messages) {
            $project = Project::getById($projectId);
            if ($messages) {
                $sortedChats[$projectId]['customer'] = User::getById($messages[0]->receiver_id);
                $sortedChats[$projectId]['freelancer'] = User::getById($messages[0]->sender_id);
            }
            if ($project) {
                $sortedChats[$projectId]['project_title'] = $project->title;
            }
        }

        return view('site/chat/index', compact('sortedChats'));
    }



    public function showChat(Request $request)
    {
        $messages = Message::getMessagesByProjectId($request->project_id);
        $project_id = $request->project_id;
        $client_id = $request->client_id ?? $request->receiver_id;
        return view('site/chat/show', compact('messages', 'project_id', 'client_id'));
    }

    public function storeMessage(Request $request)
    {
        // $data = $request->all();
        // dd($request->all());
        $data = [
            'project_id' => $request->project_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ];
        // dd($data);
        Message::storeMessage($data);
        return $this->showChat($request);
    }
}