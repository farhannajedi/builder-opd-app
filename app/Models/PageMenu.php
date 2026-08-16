<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageMenu extends Model
{
    use HasFactory;

    protected $table = 'page_menus';

    protected $fillable = [
        'opd_id',
        'title',
        'slug',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'page_menu_id')
            ->where('is_active', true)
            ->orderBy('order', 'asc');
    }
}
