<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriberCompanyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_company_id',
        'category_id',
    ];


    public function company(): BelongsTo
    {
        return $this->belongsTo(SubscriberCompany::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
