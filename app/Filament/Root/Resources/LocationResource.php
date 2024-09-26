<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\LocationResource\Pages;
use App\Filament\Root\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use App\Models\LocationTag;
use App\Models\Space;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Locations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('type')
                    ->required()
                    ->options([
                        'warehouse' => 'Warehouse',
                        'building' => 'Building',
                        'apartment' => 'Apartment',
                    ]),
                Fieldset::make('Address')
                    ->schema([
                        Textarea::make('address')
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('phone'),
                        TextInput::make('city')
                            ->required(),
                        TextInput::make('state')
                            ->required(),
                        TextInput::make('country')
                            ->required(),
                        TextInput::make('zipcode')
                            ->required(),
                        TextInput::make('geolocation')
                            ->placeholder('lat, long'),
                    ])->columns(3),

                Select::make('spaces')
                    ->multiple()
                    ->relationship('spaces', 'type')
                    ->options(Space::whereNull('location_id')->orWhere('location_id', '')->get()->pluck('name', '_id'))
                    ->label('Space')
                    ->preload(),

                Select::make('location_tag')
                    ->multiple()
                    ->relationship('locationTags', 'name')
                    ->options(LocationTag::all()->pluck('name', '_id'))
                    ->label('Location Tag')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('spaces.name')->badge(),
                Tables\Columns\TextColumn::make('locationTags.name')->badge()->limitList(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
