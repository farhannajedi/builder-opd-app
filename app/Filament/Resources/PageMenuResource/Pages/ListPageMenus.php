<?php

namespace App\Filament\Resources\PageMenuResource\Pages;

use App\Filament\Resources\PageMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageMenus extends ListRecords
{
    protected static string $resource = PageMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
