<?php

namespace App\Traits;

use App\Traits\Base\BaseTrait;
use Filament\Forms;

class IsContainer extends BaseTrait {

    protected static $label = "Is Container";


    public static function attributes(): array {

        return [
            Forms\Components\Hidden::make('is_container')
                ->default(true)
                ->required(),
        ];
    }
}
