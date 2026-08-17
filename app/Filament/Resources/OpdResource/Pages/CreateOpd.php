<?php

namespace App\Filament\Resources\OpdResource\Pages;

use App\Filament\Resources\OpdResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOpd extends CreateRecord
{
    protected static string $resource = OpdResource::class;

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
