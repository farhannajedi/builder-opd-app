<?php

namespace App\Models;

use App\Models\Opd;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

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
}
