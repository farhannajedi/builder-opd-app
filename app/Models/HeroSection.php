<?php

namespace App\Models;

use App\Models\Opd;
use App\Models\HeroBanners;
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
        return $this->hasMany(HeroBanners::class)->orderBy('order');
    }

    // jika disimpan data baru, data lama akan menjadi false / tidak aktif
    protected static function booted()
    {
        static::saving(function ($hero) {
            if ($hero->is_active) {
                // Nonaktifkan hero section lainnya untuk OPD yang sama
                static::where('opd_id', $hero->opd_id)
                    ->where('id', '!=', $hero->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
