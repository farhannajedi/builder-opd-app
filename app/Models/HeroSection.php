<?php

namespace App\Models;

use App\Models\HeroBanner;
use App\Models\Opd;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'opd_id',
        'title',
        'letters',
        'subtitle',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'letters' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function banners()
    {
        return $this->hasMany(HeroBanner::class)->orderBy('order', 'asc');
    }

    // Memastikan agar hanya ada 1 Hero Section yang aktif per OPD
    protected static function booted()
    {
        static::saving(function ($heroSection) {
            if ($heroSection->is_active) {
                // Matikan status is_active pada hero section lain milik opd_id yang sama
                static::where('opd_id', $heroSection->opd_id)
                    ->where('id', '!=', $heroSection->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
