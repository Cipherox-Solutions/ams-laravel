<?php

namespace App\Filament\Root\Resources\AuditResource\Pages;

use App\Filament\Root\Resources\AuditResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudits extends ListRecords
{
    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
