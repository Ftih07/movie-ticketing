<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster',
        'price',
        'show_time',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
