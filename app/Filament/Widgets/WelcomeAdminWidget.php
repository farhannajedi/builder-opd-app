<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeAdminWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-admin-widget';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
}
