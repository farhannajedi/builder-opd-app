<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WebsiteStatusWidget extends Widget
{
    protected static string $view = 'filament.widgets.website-status-widget';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    // tampilkan jika user mempunyai opd_id
    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && !is_null($user->opd_id);
    }
}
