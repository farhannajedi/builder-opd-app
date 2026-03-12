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
        return $this->hasMany(HeroBanner::class)->orderBy('order');
    }
}
