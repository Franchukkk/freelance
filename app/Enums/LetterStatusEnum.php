<?php

namespace App\Enums;

enum LetterStatusEnum: string
{
    case Pending = 'pending';
    case Processed = 'in_progress';
    case Closed = 'completed';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
