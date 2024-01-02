<?php

namespace App\Models;

use App\Enums\PlanAvailabilityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'is_visible',
        'deleted_at'
    ];


    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function companies()
    {
        return $this->hasMany(SubscriberCompany::class);
    }
}
