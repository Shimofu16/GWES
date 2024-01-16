<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_company_id',
        'plan_id',
        'proof_of_payment',
        'payment_method',
        'total',
        'due_date',
        'latest',
        'isPremium',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(SubscriberCompany::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
