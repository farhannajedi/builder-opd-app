<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
