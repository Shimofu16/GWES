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
        'price',
        'billing_cycle',
        'is_visible',
    ];


    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function companies()
    {
        return $this->hasMany(SubscriberCompany::class);
    }
}
