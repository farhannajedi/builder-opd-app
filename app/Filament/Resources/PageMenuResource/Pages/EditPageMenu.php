<?php

namespace App\Filament\Resources\PageMenuResource\Pages;

use App\Filament\Resources\PageMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageMenu extends EditRecord
{
    protected static string $resource = PageMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
