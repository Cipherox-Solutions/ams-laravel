<?php

namespace App\Filament\Root\Resources\VendorTagResource\Pages;

use App\Filament\Root\Resources\VendorTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorTag extends EditRecord
{
    protected static string $resource = VendorTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
