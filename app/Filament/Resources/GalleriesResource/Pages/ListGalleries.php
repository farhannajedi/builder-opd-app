<?php

namespace App\Filament\Resources\GalleriesResource\Pages;

use App\Filament\Resources\GalleriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

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
