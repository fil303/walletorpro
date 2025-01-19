<?php

namespace App\Enums;
enum StakingStatus: string
{
    case IMMATURE = 'Immature';
    case MATURE = 'Mature';
    case CANCELED = 'Canceled';
}