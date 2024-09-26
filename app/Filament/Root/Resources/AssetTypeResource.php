<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\AssetTypeResource\Pages;
use App\Filament\Root\Resources\AssetTypeResource\RelationManagers;
use App\Models\AssetType;
use App\Models\AttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetTypeResource extends Resource
{
    protected static ?string $model = AssetType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Assets';

    protected static function getTraitOptions(): array
    {
        $traitPath = app_path('Traits'); // Path to your traits folder
        $namespace = 'App\Traits\\'; // Namespace of the traits
        $options = [];

        // Get all PHP files in the traits folder
        $files = File::allFiles($traitPath);

        foreach ($files as $file) {
            $className = $namespace.str_replace('.php', '', $file->getFilename());

            // Skip the base trait class if necessary
            if ($className === $namespace.'BaseTrait') {
                continue; // Skip this class
            }

            // Check if the class exists
            if (class_exists($className)) {
                // Use Reflection to inspect the class
                $reflection = new \ReflectionClass($className);

                // Check if the class has a 'getLabel' method
                if ($reflection->hasMethod('getLabel')) {
                    // Call the static method 'getLabel'
                    $label = $className::getLabel();

                    // Add the class name and label to the options
                    if ($label) {
                        $options[$className] = $label;
                    }
                }
            }
        }

        return $options;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('icon')
                    ->required(),
                Forms\Components\ColorPicker::make('color')
                    ->required(),
                Forms\Components\Select::make('attributeGroups')
                    ->multiple()
                    ->relationship('attributeGroups', 'group_name')
                    ->options(AttributeGroup::all()->pluck('group_name', '_id'))
                    ->required(),
                Forms\Components\Select::make('traits')
                    ->multiple()
//                    ->options([
//                        "has_location"      => "has location",
//                        "has_custodian"      => "has custodian",
//                        "has_organization"      => "has Organization",
//                        "has_warranty"      => "has warranty",
//                        "has_audit"      => "has audit",
//                    ])
                    ->options(self::getTraitOptions())
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('icon'),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('attributeGroups.group_name')->badge()->limitList(),
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
            RelationManagers\AssetsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetTypes::route('/'),
            'create' => Pages\CreateAssetType::route('/create'),
            'edit' => Pages\EditAssetType::route('/{record}/edit'),
        ];
    }
}
