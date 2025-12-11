<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'duration',
        'description',
        'poster',
        'price',
        'show_time',
    ];

    // MAGIC METHOD: Generate Slug Otomatis
    protected static function booted()
    {
        static::creating(function ($movie) {
            // Otomatis bikin slug dari title saat Create
            // Contoh: "Avengers Endgame" -> "avengers-endgame"
            $movie->slug = Str::slug($movie->title);
        });

        static::updating(function ($movie) {
            // (Opsional) Update slug kalau title diganti saat Edit
            // Kalau tidak mau link rusak saat edit judul, hapus bagian ini
            if ($movie->isDirty('title')) {
                $movie->slug = Str::slug($movie->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
