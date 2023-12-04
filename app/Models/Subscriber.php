<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\SubscriberStatusEnum;
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
        'status',
    ];

    protected $casts = [

    ];

    public function company()
    {
        return $this->hasOne(SubscriberCompany::class);
    }
}
