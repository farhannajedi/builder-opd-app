<?php

namespace App\Filament\Resources\OpdConfigsResource\Pages;

use App\Filament\Resources\OpdConfigsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOpdConfigs extends CreateRecord
{
    protected static string $resource = OpdConfigsResource::class;

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
