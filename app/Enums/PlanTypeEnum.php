<?php

namespace App\Enums;

use App\Models\Plan;
use Illuminate\Support\Str;

enum PlanTypeEnum: string
{
    case STANDARD = 'standard';
    case PREMIUM = 'premium';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

}
