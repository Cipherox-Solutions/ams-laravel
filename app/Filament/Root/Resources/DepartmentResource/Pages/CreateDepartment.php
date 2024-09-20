<?php

namespace App\Filament\Root\Resources\DepartmentResource\Pages;

use App\Filament\Root\Resources\DepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;
}
