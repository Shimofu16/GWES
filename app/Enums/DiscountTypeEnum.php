<?php
namespace App\Enums;

use Illuminate\Support\Str;

enum DiscountTypeEnum : string
{
    case PERCENTAGE = 'percentage';
    case FIXED_AMOUNT = 'fixed_amount';
    case FREE_SUBSCRIPTION = 'free_subscription';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

    
}
