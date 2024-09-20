<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\SpaceResource\Pages;
use App\Filament\Root\Resources\SpaceResource\RelationManagers;
use App\Models\Space;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpaceResource extends Resource
{
    protected static ?string $model = Space::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Locations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label('name'),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        'room' => 'Room',
                        'hall' => 'Hall',
                        'garage' => 'Garage',
                        'corridor' => 'Corridor',
                        'lobby' => 'Lobby',
                    ])
                    ->required(),

                TextInput::make('floor')
                    ->label('Floor #')
                    ->numeric()
                    ->required(),

                TextInput::make('sqft')
                    ->label('Square Footage (sqft)')
                    ->numeric()
                    ->required(),

                Fieldset::make('Dimensions')
                    ->schema([
                        TextInput::make('length')
                            ->label('Length (ft)')
                            ->numeric(),

                        TextInput::make('width')
                            ->label('Width (ft)')
                            ->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TagsColumn::make('locations.name'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TagsColumn::make('floor'),
                Tables\Columns\TagsColumn::make('sqft'),

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
            'index' => Pages\ListSpaces::route('/'),
            'create' => Pages\CreateSpace::route('/create'),
            'edit' => Pages\EditSpace::route('/{record}/edit'),
        ];
    }
}
