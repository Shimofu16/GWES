<?php
namespace App\Enums;

use Illuminate\Support\Str;

enum PlanStatusEnum : string
{
    case VISIBLE = 'visible';
    case HIDDEN = 'hidden';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = Str::ucfirst($case->value);
        }
        return $array;
    }
}
