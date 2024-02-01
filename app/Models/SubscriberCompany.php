<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriberCompany extends Model
{
    use HasFactory, SoftDeletes;

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
        'status',
    ];

    protected $casts = [
        'socials' => Json::class,
    ];

    protected $appends = ['payment', 'categories', 'isPremium'];

    public function getPaymentAttribute()
    {
        return   $this->payments()
            ->where('latest', true)
            ->first();
    }
    public function getIsPremiumAttribute()
    {
        $payment = $this->payments()
            ->where('latest', true)
            ->where('isPremium', true)
            ->where('status',  PaymentStatusEnum::ACTIVE->value)
            ->first();
        if ($payment) {
            return true;
        }
        return false;
    }
    public function getCategoriesAttribute()
    {
        $companyCategories = $this->companyCategories()->pluck('id', 'category_id');
        foreach ($companyCategories as $key => $companyCategory) {
            $company_category_ids[] =  $companyCategory;
        }
        // $categories = Category::find($company_category_ids);
        return Category::find($company_category_ids)->pluck('name', 'id');
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
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class)->withTrashed();
    }
}
