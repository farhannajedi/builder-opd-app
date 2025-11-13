<?php

namespace App\Filament\Resources\NewsCategoriesResource\Pages;

use App\Filament\Resources\NewsCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsCategories extends CreateRecord
{
    protected static string $resource = NewsCategoriesResource::class;
}
