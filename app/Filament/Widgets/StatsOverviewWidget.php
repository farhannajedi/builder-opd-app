<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\News;
use App\Models\Service;
use App\Models\PlanningDocument;
use App\Models\Opd;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $user = Auth::user();
        $opdId = $user->opd_id;

        // Jika Super Admin
        if (is_null($opdId)) {
            return [
                Stat::make('Total OPD', Opd::count())
                    ->description('Organisasi Perangkat Daerah')
                    ->descriptionIcon('heroicon-m-building-office-2')
                    ->color('primary'),

                Stat::make('Total Pengguna', User::count())
                    ->description('Admin OPD & Pengelola')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('info'),
            ];
        }

        // Jika login sebagai Admin OPD
        return [
            Stat::make('Berita', News::where('opd_id', $opdId)->count())
                ->description('Total Publikasi Berita')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),

            Stat::make('Pengumuman', Announcement::where('opd_id', $opdId)->count())
                ->description('Total Pengumuman')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            Stat::make('Layanan Publik', Service::where('opd_id', $opdId)->count())
                ->description('Total Layanan Aktif')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('success'),

            Stat::make('Dokumen', PlanningDocument::where('opd_id', $opdId)->count())
                ->description('Dokumen Perencanaan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
}
