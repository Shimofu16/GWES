<?php

namespace App\Enums;

use App\Models\Plan;
use Illuminate\Support\Str;

enum CategoryTypeEnum: string
{
    case ENTERTAINMENT = 'Entertainment';
    case TRANSPORTATION = 'Transportation';
    case FOODANDBEVERAGES = 'Food and Beverages';
    case DECORATIONS = 'Decorations';
    case ATTIRE = 'Attire';
    case PHOTOGRAPHY = 'Photography';
    case OTHERS = 'Others';


    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

}
