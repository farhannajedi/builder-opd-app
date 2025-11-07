<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $fillable = [
        'opd_id',
        'title',
        'slug',
        'deskripsi',
        'images',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
