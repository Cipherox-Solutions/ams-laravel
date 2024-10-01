<?php

namespace App\Filament\Root\Resources\AssetTypeResource\RelationManagers;

use App\Filament\Root\Resources\AssetResource;
use App\Models\AssetTag;
use App\Models\AssetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'assets';

    public function form(Form $form): Form
    {
        $assetTypeId = $this->getOwnerRecord()->getKey();

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\Select::make('assetType')
                    ->relationship('assetType', 'name')
                    ->options(AssetType::where('_id', $assetTypeId)->pluck('name', '_id'))
                    ->reactive()
                    ->required()
                    ->label('Asset Type')
                    ->preload()
//                    ->default($this->getOwnerRecord()->getKey()) // not working correctly if set not populating dynamic fields
                    ->afterStateUpdated(function ($state, callable $set, $get) {

                        // populating attributes on state change
                        $assetTypeId = $get('assetType');

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


                Forms\Components\Select::make('asset_tag')
                    ->multiple()
                    ->relationship('assetTags', 'name')
                    ->options(AssetTag::all()->pluck('name', '_id'))
                    ->required()
                    ->label('Asset Tag')
                    ->preload(),

                Forms\Components\Builder::make('attributes')
                    ->visible(function (callable $get) {
                        return $get('assetType') != null;
                    })
                    ->label('Attributes')
                    ->blocks(fn(callable $get) => AssetResource::getDynamicAttributes($get('assetType')))
                    ->required()
                    ->deletable(false)
                    ->addable(false)
                    ->reorderable(false)
                    ->blockNumbers(false)
                    ->columnSpan(2),

                Forms\Components\Builder::make('traits')
                    ->visible(function (callable $get) {
                        return $get('assetType') != null;
                    })
                    ->label('Traits')
                    ->blocks(fn(callable $get) => AssetResource::getDynamicTraits($get('assetType')))
                    ->required()
                    ->deletable(false)
                    ->addable(false)
                    ->blockNumbers(false)
                    ->reorderable(false)
                    ->columnSpan(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assetType.name')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('assetTags.name')
                    ->badge()
                    ->limitList()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['saas_account_id'] = auth()->id();

                        return $data;
                    }),
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
}
