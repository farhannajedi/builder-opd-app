<?php

namespace App\Models;

use App\Models\News;
use App\Models\Opd;
use App\Traits\BelongsToOpd;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class NewsCategories extends Model
{
    use hasRoles, BelongsToOpd;

    protected $fillable = [
        'opd_id',
        'title',
        'slug',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(News::class, 'news_category_id');
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
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
