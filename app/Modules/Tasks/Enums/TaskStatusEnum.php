<?php

namespace App\Modules\Tasks\Enums;

enum TaskStatusEnum: string
{
    case PENDING = 'pending';
    case DONE = 'done';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
