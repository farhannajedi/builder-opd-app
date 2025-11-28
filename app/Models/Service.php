<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'opd_id',
        'name',
        'description',
        'published_at',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
