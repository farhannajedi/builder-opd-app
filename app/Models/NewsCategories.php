<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class NewsCategories extends Model
{
    use hasRoles;

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
