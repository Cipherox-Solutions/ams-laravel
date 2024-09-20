<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\VendorTagResource\Pages;
use App\Filament\Root\Resources\VendorTagResource\RelationManagers;
use App\Models\VendorTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorTagResource extends Resource
{
    protected static ?string $model = VendorTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    
    protected static ?string $navigationGroup = 'Vendor';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListVendorTags::route('/'),
            'create' => Pages\CreateVendorTag::route('/create'),
            'edit' => Pages\EditVendorTag::route('/{record}/edit'),
        ];
    }
}
