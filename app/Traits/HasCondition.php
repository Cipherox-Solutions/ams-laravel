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
}
