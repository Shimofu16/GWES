<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function companies()
    {
        return $this->hasMany(SubscriberCompany::class);
    }
    protected $appends = ['active_subscribers'];

    public function getActiveSubscribersAttribute()
    {
        return $this->companies()->whereHas('payments', function ($q) {
            $q->where('latest', true)
                ->where('status',  PaymentStatusEnum::ACTIVE->value);
        })
            ->get();
    }
}
