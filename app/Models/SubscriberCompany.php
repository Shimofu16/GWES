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
        'picture',
        'name',
        'description',
        'address',
        'phone',
        'socials',
        'price_range',
        'categories',
        'due_date',
        'status',
    ];

    protected $casts = [
        'socials' => Json::class,
        'categories' => Json::class,
        'due_date' => 'date',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public static function search($search){
        return self::query()
        ->where('name', 'LIKE', "%{$search}%");
    }
}
