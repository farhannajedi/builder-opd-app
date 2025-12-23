<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningDocument extends Model
{

    use \App\Traits\BelongsToOpd;
    protected $fillable = [
        'opd_id',
        'title',
        'slug',
        'content',
        'file',
        'published_at',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
