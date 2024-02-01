<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subscriber_company_id',
        'title',
        'description',
        'images',
        'date',
        'deleted_at'
    ];

    // protected $casts = [
    //     'images' => 'array',
    // ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(SubscriberCompany::class);
    }
}
