<?php

namespace App\Models;

use App\Traits\BelongsToOpd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class NewsCategories extends Model
{
    use hasRoles, BelongsToOpd;

    protected $fillable = [
        'opd_id',
        'title',
        'slug',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
