<?php

namespace App\Filament\Resources\NewsCategoriesResource\Pages;

use App\Filament\Resources\NewsCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsCategories extends EditRecord
{
    protected static string $resource = NewsCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
