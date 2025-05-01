<?php

namespace App\Services;

use App\Enums\LetterStatusEnum;
use App\Models\Letter;
use App\Models\User;

class LetterService
{
    public function create(array $data)
    {
        if (empty($data['client_name']) || empty($data['email']) || empty($data['message'])) {
            throw new \InvalidArgumentException('All fields are required.');
        }

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

    public function assignManager(Letter $message, int|string|null $managerId)
    {
        if (!is_numeric($managerId) || empty($managerId)){
            throw new \InvalidArgumentException('Manager ID is required.');
        }

        $user = User::find($managerId);

        if (!$user) {
            throw new \InvalidArgumentException('Manager not found.');
        }

        if ($user->id !== $message->manager_id) {
            throw new \InvalidArgumentException('You are not authorized to perform this action.');
        }

        $message->update([
            'manager_id' => $managerId,
        ]);

        return $message;
    }

    public function answer(Letter $message, string $answer, int $managerId)
    {
        if (empty($answer)) {
            throw new \InvalidArgumentException('Answer is required.');
        }

        if ($message->status !== LetterStatusEnum::Pending->value) {
            throw new \InvalidArgumentException('Message is not pending.');
        }

        $user = User::find($managerId);
        if (!$user) {
            throw new \InvalidArgumentException('Manager not found');
        }

        if ($user->id !== $message->manager_id) {
            throw new \InvalidArgumentException('You are not authorized to perform this action.');
        }


        $message->update([
            'answer' => $answer,
            'manager_id' => $managerId,
            'status' => LetterStatusEnum::Closed->value,
        ]);

        return $message;
    }
}
