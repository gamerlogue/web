<?php

declare(strict_types=1);

namespace App\Enums;

enum LibraryEntryStatus: string
{
    case Playing = 'PLAYING';
    case Completed = 'COMPLETED';
    case Paused = 'PAUSED';
    case Abandoned = 'ABANDONED';
    case Backlog = 'BACKLOG';
}
