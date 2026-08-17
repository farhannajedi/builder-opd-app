<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

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
