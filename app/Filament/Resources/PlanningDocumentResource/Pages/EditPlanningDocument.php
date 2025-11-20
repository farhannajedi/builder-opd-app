<?php

namespace App\Filament\Resources\PlanningDocumentResource\Pages;

use App\Filament\Resources\PlanningDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanningDocument extends EditRecord
{
    protected static string $resource = PlanningDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
