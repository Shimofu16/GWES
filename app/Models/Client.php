<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'bride',
        'groom',
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
