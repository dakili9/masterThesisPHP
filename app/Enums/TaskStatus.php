<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'Pending';
    case Completed = 'Completed';
    case InProgress = 'In progress';
    case OnHold = 'On hold';

    /**
     * Get all task status values.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
