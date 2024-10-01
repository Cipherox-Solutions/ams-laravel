<?php

namespace App\Traits;

use App\Models\Asset;
use App\Models\Location;
use App\Traits\Base\BaseTrait;
use Filament\Forms;

class HasLocation extends BaseTrait
{

    protected static string $label = "Has Location";

    public static function attributes(): array
    {

        return [
            Forms\Components\Select::make('location')
                ->label("Location")
                ->live()
                ->options(Location::all()->pluck('name', '_id'))
                ->required()
                ->afterStateUpdated(function (Forms\Set $set) {
                    $set('space', null);
                    $set('container', null);
                    $set('positions', null);
                }),
            Forms\Components\Select::make('space')
                ->label("Space")
                ->live()
                ->required()
                ->options(function (callable $get) {
                    $location_id = $get("location");

                    if (!$location_id) {
                        return [];
                    }

                    return Location::find($location_id)->spaces->pluck('type', '_id');
                })
                ->preload()
                ->afterStateUpdated(function (Forms\Set $set) {
                    $set('container', null);
                    $set('positions', null);
                }),

            Forms\Components\Select::make('container')
                ->label("Container")
                ->live()
                ->options(function (callable $get) {
                    $space_id = $get("space");

                    if (!$space_id) {
                        return [];
                    }

                    $asset_id = null;

                    if (request()->route()->parameter('record')) {
                        $asset_id = request()->route()->parameter('record');
                    }

                    return Asset::where('traits.data.space', $space_id)
                        ->where('traits.data.is_container', '=', true)
                        ->where('_id', '!=', $asset_id)
                        ->pluck('name', '_id');
                })
                ->preload()
                ->afterStateUpdated(function (Forms\Set $set) {
                    $set('positions', null);
                }),
            Forms\Components\Select::make('positions')
                ->label('Positions')
                ->visible(fn(callable $get) => $get("container") != null)
                ->options(function (callable $get) {
                    $container_id = $get("container");

                    if (!$container_id) {
                        return [];
                    }

                    /*Asset::where('_id', $containerId)
                            ->pluck('traits') // Get only the traits field
                            ->map(function ($traits) {
                                return collect($traits)
                                    ->where('type', 'Is Container') // Filter for the correct trait type
                                    ->flatMap(function ($trait) {
                                        return collect($trait['data']['positions'] ?? [])
                                            ->pluck('name'); // Extract the name from each position
                                    });
                            })
                            ->flatten() // Flatten the collection of names
                            ->unique() // Get unique position names if necessary
                            ->values() // Reset the array keys
                            ->toArray();*/

                    $asset = Asset::where('_id', $container_id)->first();

                    if (!$asset || !isset($asset->traits)) {
                        return [];
                    }

                    $positions = collect($asset->traits)
                        ->where('type', 'Is Container')
                        ->flatMap(function ($trait) {
                            return collect($trait['data']['positions'] ?? [])
                                ->pluck('name');
                        })
                        ->flatten()
                        ->unique()
                        ->values()
                        ->toArray();
                    return array_combine($positions, $positions);
                })
                ->required(),
        ];
       // return FormHelper::createAllFilamentFormField([
       //     "asda"  => [
       //         "label" => ""
       //
       //     ],
       //
       // ]);
    }


}
