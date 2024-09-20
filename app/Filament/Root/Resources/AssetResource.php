<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\AssetResource\Pages;
use App\Filament\Root\Resources\AssetResource\RelationManagers;
use App\Helpers\FormHelper;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\AssetTag;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Assets';

    protected static function getDynamicAttributes($assetTypeId): array
    {
        if (!$assetTypeId) {
            return [];
        }

        $attributeGroups = AssetType::find($assetTypeId)->attributeGroups;
        // $assetType = AssetType::find($assetTypeId);
        // $attributeGroups = AttributeGroup::whereIn('asset_type_id', $assetTypeId)->get();

        $blocks = [];
        foreach ($attributeGroups as $attributeGroup) {
            $attributes = $attributeGroup->attributes;

            $fields = [];
            foreach ($attributes as $attr) {

                $field = FormHelper::createFilamentFormField($attr);

                // $fields[] = Forms\Components\Builder\Block::make($attr['label'])
                //                 ->schema([$field]);
                $fields[] = $field;
            }

            $blocks[] = Block::make($attributeGroup['group_name'])
                ->schema($fields)
                ->maxItems(1);
        }

        return $blocks;

        // return [
        //     Forms\Components\Builder\Block::make('attributes')
        //         ->schema($fields)
        //         ->label('Attributes'),
        // ];
    }

    protected static function getDynamicTraits($assetTypeId): array
    {
        if (!$assetTypeId) {
            return [];
        }

        $traits = AssetType::find($assetTypeId)->traits;

        $blocks = [];
        foreach ($traits as $trait) {
            $block = Block::make($trait::getLabel())
                ->schema($trait::attributes())
                ->columns(3);

//            if ($trait === 'App\Traits\IsContainer') {
//                $block->hidden();
//            }

            $blocks[] = $block;
        }

        return $blocks;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Select::make('asset_type_id')
                    ->relationship('assetType', 'name')
                    ->options(AssetType::all()->pluck('name', '_id'))
                    ->reactive()
                    ->required()
                    ->label('Asset Type')
                    ->preload()
                    ->afterStateUpdated(function ($state, callable $set, $get) {

                        // populating attributes on state change
                        $assetTypeId = $get('asset_type_id');

                        if (!$assetTypeId) {
                            return [];
                        }

                        $asset = AssetType::find($assetTypeId);

                        $attributeGroups = $asset->attributeGroups;

                        $default_val = [];
                        foreach ($attributeGroups as $attributeGroup) {
                            $default_val[] = [
                                'type' => $attributeGroup['group_name']
                            ];
                        }

                        $set("attributes", $default_val);

                        // populating traits on state change
                        $traits = $asset->traits;

                        $default_val = [];
                        foreach ($traits as $trait_class) {
                            $default_val[] = [
                                'type' => $trait_class::getLabel()
                            ];
                        }

                        $set("traits", $default_val);
                    }),


                Select::make('asset_tag')
                    ->multiple()
                    ->relationship('assetTags', 'name')
                    ->options(AssetTag::all()->pluck('name', '_id'))
                    ->required()
                    ->label('Asset Tag')
                    ->preload(),

                Builder::make('attributes')
                    ->visible(function (Forms\Get $get) {
                        return $get('asset_type_id') != null;
                    })
                    ->label('Attributes')
                    ->blocks(fn(callable $get) => self::getDynamicAttributes($get('asset_type_id')))
//                    ->minItems(fn(Forms\Get $get) => count(self::getDynamicAttributes($get('asset_type_id'))))
//                    ->maxItems(fn(Forms\Get $get) => count(self::getDynamicAttributes($get('asset_type_id'))))
                    ->required()
                    ->deletable(false)
                    ->addable(false)
                    ->reorderable(false)
                    ->blockNumbers(false)
                    ->columnSpan(2),

                Builder::make('traits')
                    ->visible(function (Forms\Get $get) {
                        return $get('asset_type_id') != null;
                    })
                    ->label('Traits')
                    ->blocks(fn(callable $get) => self::getDynamicTraits($get('asset_type_id')))
                    ->required()
                    ->deletable(false)
                    ->addable(false)
                    ->blockNumbers(false)
                    ->reorderable(false)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TagsColumn::make('assetType.name'),
                Tables\Columns\TagsColumn::make('assetTags.name')->limitList(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }

}
