<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
