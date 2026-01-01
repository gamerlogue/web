<?php

namespace App\Enums;

enum LibraryEntryCompletionStatus: string
{
    case MainStory = 'MAIN_STORY';
    case MainPlusSides = 'MAIN_PLUS_SIDES';
    case Full100 = 'FULL_100';
}
