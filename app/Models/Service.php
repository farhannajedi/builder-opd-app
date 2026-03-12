<?php

namespace App\Models;

use App\Models\Opd;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{

    use \App\Traits\BelongsToOpd;
    protected $fillable = [
        'opd_id',
        'name',
        'description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
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
