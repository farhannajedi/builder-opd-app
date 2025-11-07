<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningDocument extends Model
{
    protected $fillable = [
        'opd_id',
        'title',
        'content',
        'file',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
