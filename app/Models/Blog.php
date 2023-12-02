<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_company_id',
        'title',
        'description',
        'images',
    ];

    public function company()
    {
        return $this->belongsTo(SubscriberCompany::class, 'subscriber_company_id');
    }
}
