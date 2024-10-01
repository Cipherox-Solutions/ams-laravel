<?php

namespace App\Filament\Root\Resources\AssetResource\Pages;

use App\Filament\Root\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsset extends CreateRecord {
    protected static string $resource = AssetResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($data['traits'] as &$trait) {
            if ($trait['type'] === 'Is Container') {
                $trait['data']['is_container'] = true;
                break;
            }
        }

        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
