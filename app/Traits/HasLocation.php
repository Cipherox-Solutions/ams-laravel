<?php

namespace App\Traits;

use App\Models\Asset;
use App\Models\Location;
use App\Traits\Base\BaseTrait;
use Filament\Forms;

class HasLocation extends BaseTrait {

    protected static $label = "Has Location";

    public static function attributes() {

        return [
            Forms\Components\Select::make('location')
                ->options(Location::all()->pluck('name', '_id'))
                ->required()
                ->reactive(),
            Forms\Components\Select::make('space')
                ->required()
                ->options(function(callable $get ){
                    $location_id = $get("location");

                    if (!$location_id) {
                        return [];
                    }

                    return Location::find($location_id)->spaces->pluck('type', '_id');
                })
                ->preload()
                ->reactive(),

            Forms\Components\Select::make('container')
                ->options(function(callable $get){
                    $space_id = $get("space");

                    if (!$space_id) {
                        return [];
                    }

                    return Asset::where('traits.data.space', $space_id)
                        ->where('traits.type', 'Is Container')->pluck('name', 'id');
                }),
        ];
//        return FormHelper::createAllFilamentFormField([
//            "asda"  => [
//                "label" => ""
//
//            ],
//
//        ]);
    }


}
