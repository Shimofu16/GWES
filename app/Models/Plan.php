<?php

namespace App\Models;

use App\Enums\PlanAvailabilityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'is_visible',
        'discount_price',
        'discount_percentage',
        'availability',
    ];


    protected $casts = [
        'availability' => PlanAvailabilityEnum::class,
        'is_visible' => 'boolean',
    ];

    public function companies()
    {
        return $this->hasMany(SubscriberCompany::class);
    }
}
