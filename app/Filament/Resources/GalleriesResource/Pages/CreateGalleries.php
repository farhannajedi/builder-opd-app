<?php

namespace App\Filament\Resources\GalleriesResource\Pages;

use App\Filament\Resources\GalleriesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGalleries extends CreateRecord
{
    protected static string $resource = GalleriesResource::class;

    // Memaksa opd_id dari serverny
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if ($user->opd_id !== null) {
            $data['opd_id'] = $user->opd_id;
        }

        return $data;
    }
}
