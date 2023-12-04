<?php

namespace App\Enums;

use App\Models\Plan;
use Illuminate\Support\Str;

enum PlanAvailabilityEnum: string
{
    case OneMonth = '1';
    case OneYear = '12';
    case TwoYears = '24';
    case FourYears = '48';


    public static function toArrayAll(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }
    public static function toArrayFiltered(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $plan = Plan::where('availability', $case->value)->first();
            if (!$plan) {
                $array[$case->value] = $case->value;
            }
        }
        return $array;
    }
}
