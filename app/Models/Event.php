<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'coordinator_name',
        'type',
        'province',
        'city',
        'address',
        'date_start',
        'date_end',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
