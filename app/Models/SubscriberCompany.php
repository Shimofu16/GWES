<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'plan_id',
        'logo',
        'name',
        'description',
        'address',
        'phone',
        'socials',
        'price_range',
        'categories',
    ];

    protected $casts = [
        'socials' => Json::class,
        'categories' => Json::class,
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
