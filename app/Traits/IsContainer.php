<?php

namespace App\Traits;

use App\Traits\Base\BaseTrait;
use Filament\Forms;

class IsContainer extends BaseTrait
{

    protected static string $label = "Is Container";


    public static function attributes(): array
    {

        return [
            Forms\Components\TextInput::make('is_container')
                ->default(true)
                ->hidden(),
            Forms\Components\Repeater::make('positions')
                ->schema([
                    Forms\Components\TextInput::make('name')->required(),
                ])
                ->addActionLabel('Add a new position'),
        ];
    }
//    public static function actions(): array {
//        return [
//            "damaged"   => [
//                "form"          => [
//                    "person"            => "",
//                    "repairable"        => "",
//                    "dispose"           => "",
//                    "image"             => "",
//                    "description"       => "",
//                ],
//                "handler"       => function($entity , $form) {
//                    action_history:save([]);
//                    $entity->status = "damaged";
//                    $entity->assignee = null;
//
//                    $entity->save();
//                },
//            ],
//
//        ];
//    }
}
