<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bride',
        'groom',
        'deleted_at'
    ];

    protected $casts = [
        'bride' => Json::class,
        'groom' => Json::class,
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
