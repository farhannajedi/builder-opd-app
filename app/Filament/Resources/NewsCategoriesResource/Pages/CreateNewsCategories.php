<?php

namespace App\Filament\Resources\NewsCategoriesResource\Pages;

use App\Filament\Resources\NewsCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsCategories extends CreateRecord
{
    protected static string $resource = NewsCategoriesResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $user = filament()->auth()->user();

    //     // Set otomatis opd_id sesuai user login
    //     $data['opd_id'] = $user->opd_id;

    //     return $data;
    // }
}