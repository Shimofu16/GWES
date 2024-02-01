<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\PlanAvailabilityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'categories',
        'duration',
        'billing_cycle',
        'type',
        'deleted_at'
    ];


    protected $casts = [
        'is_visible' => 'boolean',
        // 'billing_cycle' => enum,
        // 'type' => enum,
    ];

    protected $appends = ['companies'];

    public function getCompaniesAttribute()
    {
        return $this->payments()->where('latest', true)->count();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
