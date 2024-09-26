<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\AttributeResource\Pages;
use App\Filament\Root\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Attributes';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('label')
                    ->required(),
                Forms\Components\Toggle::make('required')
                    ->required(),
                Forms\Components\TextInput::make('default'),

                // Main attribute type selector
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'Textarea'       => 'Textarea',
                        'Select'         => 'Select',
                        'Radio'          => 'Radio',
                        'TextInput'      => 'Text Input',
                        'RichEditor'     => 'Rich Editor',
                        'DateTimePicker' => 'Date Time Picker',
                        'DatePicker'     => 'Date Picker',
                        'TimePicker'     => 'Time Picker',
                        'TagsInput'      => 'Tags Input',
                        'ColorPicker'    => 'Color Picker',
                        'ToggleButtons'  => 'Toggle Buttons',
                        'Hidden'         => 'Hidden',
                    ])->live(),

                Forms\Components\Repeater::make('options')
                    ->visible(function (Forms\Get $get) {
                        return in_array($get('type'), ['Select', 'Radio', 'ToggleButtons']);
                    })
                    ->schema([
                        Forms\Components\TextInput::make('option_value')
                            ->required()
                            ->unique(),
                        Forms\Components\TextInput::make('option_label')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Select::make('input_type')
                    ->visible(function (Forms\Get $get) {
                        return $get('type') == 'TextInput';
                    })
                    ->options([
                        'email'    => 'Email',
                        'password' => 'Password',
                        'numeric'  => 'Numeric',
                        'integer'  => 'Integer',
                        'tel'      => 'Telephone',
                        'url'      => 'URL',
                    ]),

                Forms\Components\TextInput::make('placeholder')
                    ->visible(function (Forms\Get $get) {
                        return in_array($get('type'), ['TextInput', 'Textarea']);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('type')->badge(),
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
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
