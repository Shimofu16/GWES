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
    ];

    protected $appends = [
        'active_companies',
    ];

    public function getActiveCompaniesAttribute(){
        return $this->companies()->where('status', SubscriberStatusEnum::ACTIVE->value)->get();
    }

    public function companies()
    {
        return $this->hasMany(SubscriberCompany::class);
    }
}
