<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubscriberCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'logo',
        'image',
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

    protected $appends = ['payment'];

    public function getPaymentAttribute()
    {
        return   $this->payments()
            ->where('latest', true)

            ->first();
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function companyCategories(): HasMany
    {
        return $this->hasMany(SubscriberCompanyCategory::class);
    }
}
