<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    use \App\Traits\BelongsToOpd;
    protected $fillable = [
        'opd_id',
        'title',
        'images',
        'description',
        'published_at',
    ];

    // isi slug otomatis
    protected static function boot()
    {
        parent::boot();

        // Setiap kali data galeri dibuat (creating)
        static::creating(function ($gallery) {
            // Jika slug kosong, buat otomatis dari title
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
