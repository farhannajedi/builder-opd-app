<?php

namespace App\Filament\Resources\HeroSectionResource\Pages;

use App\Filament\Resources\HeroSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroSection extends EditRecord
{
    protected static string $resource = HeroSectionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Suntikkan opd_id ke banner jika ada penambahan banner baru saat edit
        if (isset($data['banners']) && is_array($data['banners'])) {
            foreach ($data['banners'] as $key => $banner) {
                $data['banners'][$key]['opd_id'] = $data['opd_id'];
            }
        }

        return $data;
    }
}
