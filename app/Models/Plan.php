<?php

namespace App\Models;

use App\Enums\PlanStatusEnum;
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
        // 'from',
        // 'to',
    ];

    protected $casts = [
        // 'status' => PlanStatusEnum::class,
        'is_visible' => 'boolean',
    ];
}
