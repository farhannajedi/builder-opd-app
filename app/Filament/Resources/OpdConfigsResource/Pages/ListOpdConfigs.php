<?php

namespace App\Filament\Resources\OpdConfigsResource\Pages;

use App\Filament\Resources\OpdConfigsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOpdConfigs extends ListRecords
{
    protected static string $resource = OpdConfigsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
