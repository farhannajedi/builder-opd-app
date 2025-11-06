<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdConfigs extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_id',
        'logo',
        'favicon',
        'address',
        'phone',
        'email',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'tiktok_url',
        'youtube_url',
        'homepage_layout',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
