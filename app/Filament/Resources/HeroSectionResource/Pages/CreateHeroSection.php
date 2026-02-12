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
        $auth = Auth::user();

        if (!is_null($auth->opd_id)) {
            $data['opd_id'] = $auth->opd_id;
        }

        if (isset($data['banners']) && is_array($data['banners'])) {
            foreach ($data['banners'] as $key => $banner) {
                $data['banners'][$key]['opd_id'] = $data['opd_id'];
            }
        }

        return $data;
    }
}
