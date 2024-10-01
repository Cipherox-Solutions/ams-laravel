<?php

namespace App\Traits;

use App\Traits\Base\BaseTrait;
use Filament\Forms;

class HasCondition extends Base\BaseTrait
{
    protected static string $label = 'Has Condition';

    public static function attributes(): array {

        return [
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'new' => 'New',
                    'used' => 'Used',
                    'damaged' => 'Damaged',
                ])
        ];
    }
    public static function actions(): array {
        return [
            "damaged"  => [
                "label" => "Damaged",
                "form"  => "damaged_form",
                "handler"=> "",
            ],
        ];
    }
    public function damagedForm($asset_id): array {
        return [

        ];
    }
    public function handler($asset_id , $submitted_form ): array {
        return [

        ];
    }
}
