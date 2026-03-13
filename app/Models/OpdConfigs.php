<?php

namespace App\Models;

use App\Models\Opd;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OpdConfigs extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_id',
        'logo',
        'favicon',
        'address',
        'phone',
        'email',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'tiktok_url',
        'youtube_url',
        'homepage_layout',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    // ditulis di filament
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
