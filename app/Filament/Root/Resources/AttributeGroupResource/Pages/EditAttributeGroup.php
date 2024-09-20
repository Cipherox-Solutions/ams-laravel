<?php

namespace App\Filament\Root\Resources\AttributeGroupResource\Pages;

use App\Filament\Root\Resources\AttributeGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttributeGroup extends EditRecord
{
    protected static string $resource = AttributeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
