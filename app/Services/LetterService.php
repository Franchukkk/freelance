<?php

namespace App\Services;

use App\Enums\LetterStatusEnum;
use App\Models\Letter;

class LetterService
{
    public function create(array $data)
    {

        return Letter::create([
            'client_name' => $data['client_name'],
            'email'       => $data['email'],
            'message'     => $data['message'],
            'status'      => LetterStatusEnum::Pending->value, // Статус за замовченням
        ]);
    }

    public function changeStatus(Letter $message, LetterStatusEnum $status)
    {
        $message->update([
            'status' => $status->value,
        ]);

        return $message;
    }

    public function assignManager(Letter $message, int $managerId)
    {

        $message->update([
            'manager_id' => $managerId,
        ]);

        return $message;
    }

    public function answer(Letter $message, string $answer, int $managerId)
    {
        $message->update([
            'answer' => $answer,
            'manager_id' => $managerId,
            'status' => LetterStatusEnum::Closed->value,
        ]);

        return $message;
    }
}
