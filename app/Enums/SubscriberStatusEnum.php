<?php
namespace App\Enums;

use Illuminate\Support\Str;

enum SubscriberStatusEnum : string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }

    public static function getIcon(string $status): string
    {
        switch ($status) {
            case 'pending':
                return 'heroicon-o-clock';
            case 'active':
                return 'heroicon-o-check-circle';
            case 'inactive':
                return 'heroicon-o-x-circle';
            default:
                return 'heroicon-o-x-circle';
        }
    }
}
