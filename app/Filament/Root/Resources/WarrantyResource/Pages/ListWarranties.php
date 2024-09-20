<?php

namespace App\Filament\Root\Resources\WarrantyResource\Pages;

use App\Filament\Root\Resources\WarrantyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWarranties extends ListRecords
{
    protected static string $resource = WarrantyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
