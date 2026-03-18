<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        'opd_id',
        'nama_kepala_dinas',
        'sambutan_kepala',
        'gambar',
        'tentang_kami',
        'visi',
        'misi',
        'penjelasan_tugas',
        'tugas',
        'fungsi',
        'bagan_struktur',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // isi slug otomatis
    protected static function booted()
    {
        $slug = getenv('APP_ID');

        if ($slug) {
            static::addGlobalScope('filterOPD', function (Builder $builder) use ($slug) {
                // Mencari berita yang memiliki relasi ke tabel OPD dengan slug tertentu
                $builder->whereHas('opd', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            });
        }
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }
}
