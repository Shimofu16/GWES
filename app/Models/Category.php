<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'deleted_at'
    ];

    public function subscribersCount()
    {
        return SubscriberCompany::whereJsonContains('categories', ['id' =>  $this->id])->count();
    }
}