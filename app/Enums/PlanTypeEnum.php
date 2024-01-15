<?php

namespace App\Enums;

use App\Models\Plan;
use Illuminate\Support\Str;

enum PlanTypeEnum: string
{
    case STANDARD_A= 'standard a';
    case STANDARD_B = 'standard b';
    case PREMIUM_A = 'premium a';
    case PREMIUM_B = 'premium b';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

}
