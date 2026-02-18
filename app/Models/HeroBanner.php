<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $fillable = [
        'opd_id',
        'hero_section_id',
        'image_path',
        'order',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($banner) {
            // Jika opd_id kosong, ambil dari HeroSection induknya
            if (blank($banner->opd_id)) {
                $banner->opd_id = $banner->heroSection->opd_id;
            }
        });
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
