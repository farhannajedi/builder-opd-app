<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'page';

    protected $fillable = [
        'opd_id',
        'page_menu_id',
        'badge_text',
        'title',
        'slug',
        'subtitle',
        'content',
        'is_active',
        'order',

    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function page_menu()
    {
        return $this->belongsTo(PageMenu::class, 'page_menu_id');
    }
}
