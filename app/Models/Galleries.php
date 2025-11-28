<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    protected $fillable = [
        'opd_id',
        'title',
        'images',
        'description',
        'published_at',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
