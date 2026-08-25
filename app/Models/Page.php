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

    // Mengatur input urutan konten
    protected static function booted(): void
    {
        static::creating(function (Page $page) {

            $order = max(1, (int) $page->order);

            Page::where('page_menu_id', $page->page_menu_id)
                ->where('opd_id', $page->opd_id)
                ->where('order', '>=', $order)
                ->increment('order');

            $page->order = $order;
        });

        static::updating(function (Page $page) {

            if (
                $page->isDirty('order') ||
                $page->isDirty('page_menu_id') ||
                $page->isDirty('opd_id')
            ) {

                $oldOrder = (int) $page->getOriginal('order');
                $newOrder = max(1, (int) $page->order);

                // Pindah menu
                if (
                    $page->isDirty('page_menu_id') ||
                    $page->isDirty('opd_id')
                ) {
                    Page::where('page_menu_id', $page->getOriginal('page_menu_id'))
                        ->where('opd_id', $page->getOriginal('opd_id'))
                        ->where('order', '>', $oldOrder)
                        ->decrement('order');

                    Page::where('page_menu_id', $page->page_menu_id)
                        ->where('opd_id', $page->opd_id)
                        ->where('id', '!=', $page->id)
                        ->where('order', '>=', $newOrder)
                        ->increment('order');

                    $page->order = $newOrder;

                    return;
                }

                // Pindah posisi lebih awal
                if ($newOrder < $oldOrder) {

                    Page::where('page_menu_id', $page->page_menu_id)
                        ->where('opd_id', $page->opd_id)
                        ->where('id', '!=', $page->id)
                        ->whereBetween('order', [$newOrder, $oldOrder - 1])
                        ->increment('order');
                }

                // Pindah posisi lebih akhir
                elseif ($newOrder > $oldOrder) {

                    Page::where('page_menu_id', $page->page_menu_id)
                        ->where('opd_id', $page->opd_id)
                        ->where('id', '!=', $page->id)
                        ->whereBetween('order', [$oldOrder + 1, $newOrder])
                        ->decrement('order');
                }

                $page->order = $newOrder;
            }
        });

        static::deleted(function (Page $page) {

            Page::where('page_menu_id', $page->page_menu_id)
                ->where('opd_id', $page->opd_id)
                ->where('order', '>', $page->order)
                ->decrement('order');
        });
    }
}
