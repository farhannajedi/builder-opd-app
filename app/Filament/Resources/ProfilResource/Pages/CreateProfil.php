<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use App\Filament\Resources\ProfilResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProfil extends CreateRecord
{
    protected static string $resource = ProfilResource::class;

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
