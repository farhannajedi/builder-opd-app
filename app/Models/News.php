<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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


    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function category()
    {
        return $this->belongsTo(NewsCategories::class, 'category_id');
    }
}
