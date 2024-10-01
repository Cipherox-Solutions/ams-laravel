<?php

namespace App\Filament\Root\Resources;

use App\Filament\Root\Resources\UserResource\Pages;
use App\Filament\Root\Resources\UserResource\RelationManagers;
use App\Models\Department;
use App\Models\Division;
use App\Models\Location;
use App\Models\Organization;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(static fn ($state) => \Hash::make($state))
                    ->visibleOn('create'), // Only show password field on create

                Forms\Components\Toggle::make('has_login')
                    ->label('Has Login')
                    ->inline(false),

                Forms\Components\Select::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name')
                    ->options(Role::all()->pluck('name', '_id'))
                    ->multiple()
                    ->preload()
                    ->searchable(),

                Forms\Components\Select::make('organization_id')
                    ->label('Organization')
                    ->live()
                    ->relationship('organization', 'name')
                    ->required()
                    ->afterStateUpdated(function (Forms\Set $set) {
                        $set('division_id', null);
                        $set('department_id', null);
                    }),

                Forms\Components\Select::make('division_id')
                    ->label('Division')
                    ->live()
                    ->relationship('division', 'name')
                    ->options(function (Forms\Get $get) {
                        $organizationId = $get('organization_id');
                        if (!$organizationId) {
                            return [];
                        }
                        return Division::where('organization_id', $organizationId)
                            ->pluck('name', '_id');
                    })
                    ->required()
                    ->afterStateUpdated(function (Forms\Set $set) {
                        $set('department_id', null);
                    }),

                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->options(function (Forms\Get $get) {
                        $divisionId = $get('division_id');
                        if (!$divisionId) {
                            return [];
                        }
                        return Department::where('division_id', $divisionId)
                            ->pluck('name', '_id');
                    })
                    ->required(),

                Forms\Components\Select::make('location_id')
                    ->label('Location')
                    ->relationship('location', 'name')
                    ->required(),

                Forms\Components\FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->directory('avatars')
                    ->maxSize(1024), // Set file size limit to 1MB
            ]);
    }

    public static function table(Table $table): Table
    {
        Column::configureUsing(function (Column $column): void {
            $column
                ->toggleable()
                ->sortable();
        });

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\IconColumn::make('has_login')
                    ->label('Has Login')
                    ->boolean(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Organization')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('division.name')
                    ->label('Division')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location.name')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                TernaryFilter::make('has_login')
                    ->label('Has Login')
                    ->boolean(),

                // SelectFilter::make('roles')
                //     ->label('Roles')
                //     ->relationship('roles', 'name')
                //     ->options(Role::all()->pluck('name', '_id')),

                SelectFilter::make('organization')
                    ->label('Organization')
                    ->relationship('organization', 'name')
                    ->options(Organization::all()->pluck('name', '_id')),

                SelectFilter::make('division')
                    ->label('Division')
                    ->relationship('division', 'name')
                    ->options(Division::all()->pluck('name', '_id')),

                SelectFilter::make('department')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->options(Department::all()->pluck('name', '_id')),

                SelectFilter::make('location')
                    ->label('Location')
                    ->relationship('location', 'name')
                    ->options(Location::all()->pluck('name', '_id')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
