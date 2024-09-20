<?php

namespace App\Filament\Root\Resources\AuditResource\Pages;

use App\Filament\Root\Resources\AuditResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAudit extends CreateRecord
{
    protected static string $resource = AuditResource::class;
}
