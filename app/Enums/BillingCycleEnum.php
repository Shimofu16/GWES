<?php

namespace App\Enums;

use App\Models\Plan;
use Illuminate\Support\Str;

enum BillingCycleEnum: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

}
