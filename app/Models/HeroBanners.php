<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanners extends Model
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

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
