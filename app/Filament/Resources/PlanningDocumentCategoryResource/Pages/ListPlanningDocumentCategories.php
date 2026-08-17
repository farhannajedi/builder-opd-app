<?php

namespace App\Filament\Resources\PlanningDocumentCategoryResource\Pages;

use App\Filament\Resources\PlanningDocumentCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListPlanningDocumentCategories extends ListRecords
{
    protected static string $resource = PlanningDocumentCategoryResource::class;

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
