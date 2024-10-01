<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\OrganizationResource\Pages;
use App\Filament\Root\Resources\OrganizationResource\RelationManagers;
use App\Helpers\FormHelper;
use App\Models\Organization;
use App\Models\Attribute;
use App\Models\Division;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Organization';

    public static function form(Form $form): Form
    {

        /*

            logo
            website
            email
            registration

        */
        return $form
            ->schema(array_merge([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),

                // Forms\Components\Select::make('divisions')
                //     ->multiple()
                //     ->relationship('divisions', 'name')
                //     ->options(Division::all()->pluck('name', '_id'))
                //     // ->options(Division::whereNull('division_id')->orWhere('division_id', '')->get()->pluck('name', '_id'))
                //     ->label('Division')
                //     ->preload(),

                Forms\Components\FileUpload::make('logo')
                    ->image(),
                Forms\Components\TextInput::make('website'),
                Forms\Components\TextInput::make('email')
                    ->email(),
                Forms\Components\TextInput::make('registration')

            ], FormHelper::global_common_fields(['custom_fields'])));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('website'),
                Tables\Columns\TextColumn::make('email'),
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
