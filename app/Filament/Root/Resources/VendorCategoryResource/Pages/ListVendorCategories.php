<?php

namespace App\Filament\Root\Resources\VendorCategoryResource\Pages;

use App\Filament\Root\Resources\VendorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorCategories extends ListRecords
{
    protected static string $resource = VendorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
