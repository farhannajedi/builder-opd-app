<?php

namespace App\Filament\Resources\PlanningDocumentCategoryResource\Pages;

use App\Filament\Resources\PlanningDocumentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanningDocumentCategories extends ListRecords
{
    protected static string $resource = PlanningDocumentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
