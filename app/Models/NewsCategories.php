<?php

namespace App\Models;

use App\Traits\BelongsToOpd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
