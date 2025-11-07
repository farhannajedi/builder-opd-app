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

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function newsCategories()
    {
        return $this->belongsTo(NewsCategories::class, 'category_id');
    }
}
