<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportReason: string
{
    case Spam = 'spam';
    case Harassment = 'harassment';
    case HateSpeech = 'hate_speech';
    case Spoiler = 'spoiler';
    case Inappropriate = 'inappropriate';
    case Impersonation = 'impersonation';
    case Other = 'other';
}
