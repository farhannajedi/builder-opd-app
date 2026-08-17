<?php

namespace App\Filament\Resources\HeroSectionResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\HeroSectionResource;

class CreateHeroSection extends CreateRecord
{
    protected static string $resource = HeroSectionResource::class;

    // Memaksa opd_id dari serverny
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        // opd_id harus selalu mengikuti OPD dari akun login.
        if ($user->opd_id !== null) {
            $data['opd_id'] = $user->opd_id;
        }

        // opd_id tetap menggunakan OPD yang dipilih dari form.

        $opdId = $data['opd_id'] ?? null;

        // Pastikan setiap banner mengikuti OPD yang sama
        if (isset($data['banners']) && is_array($data['banners'])) {
            foreach ($data['banners'] as $key => $banner) {
                $data['banners'][$key]['opd_id'] = $opdId;
            }
        }

        return $data;
    }
}
