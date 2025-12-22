<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    protected $fillable = [
        'opd_id',
        'category_id',
        'title',
        'slug',
        'deskripsi',
        'images',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        $slug = getenv('APP_ID'); // Isinya 'tp-pkk'

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

    public function category()
    {
        return $this->belongsTo(NewsCategories::class, 'category_id');
    }
}
