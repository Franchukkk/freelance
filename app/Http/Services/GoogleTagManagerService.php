<?php

namespace App\Http\Services;

class GoogleTagManagerService
{
    public function viewTaskPage($task)
    {
        return [
            'event' => 'view_task_page',
            'task_id' => $task->id,
            'task_title' => $task->title,
        ];
    }

    public function createDisputePage($data)
    {
        return [
            'event' => 'create_dispute',
            'project_id' => $data["project_id"],
            'complainant_id' => $data["complainant_id"],
            'respondent_id' => $data["respondent_id"],
        ];
    }
}