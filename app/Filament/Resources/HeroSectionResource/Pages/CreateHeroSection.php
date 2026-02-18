<?php

namespace App\Filament\Resources\HeroSectionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\HeroSectionResource;

class CreateHeroSection extends CreateRecord
{
    protected static string $resource = HeroSectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil opd_id dari form utama, jika kosong ambil dari user login
        $opdId = $data['opd_id'] ?? Auth::user()->opd_id;

        $data['opd_id'] = $opdId;

        if (isset($data['banners']) && is_array($data['banners'])) {
            foreach ($data['banners'] as $key => $banner) {
                $data['banners'][$key]['opd_id'] = $opdId;
            }
        }

        return $data;
    }
}
