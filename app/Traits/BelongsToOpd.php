<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToOpd
{
    public static function scopeForCurrentOpd(Builder $query): Builder
    {
        $user = Auth::user();

        // jika user memiliki opd_id maka filter
        if ($user && $user->opd_id !== null) {
            return $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
