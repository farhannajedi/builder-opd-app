<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\News;
use App\Models\Opd;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ActivityAndQuickAccessWidget extends Widget
{
    protected static string $view = 'filament.widgets.activity-and-quick-access-widget';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Auth::user();
        $opdId = $user->opd_id;

        return [
            'isSuperAdmin' => is_null($opdId),
            'recentNews' => News::when($opdId, fn($q) => $q->where('opd_id', $opdId))->latest()->take(3)->get(),
            'recentAnnouncement' => Announcement::when($opdId, fn($q) => $q->where('opd_id', $opdId))->latest()->take(2)->get(),
            'recentOpds' => is_null($opdId) ? Opd::latest()->take(4)->get() : collect(),
        ];
    }
}
