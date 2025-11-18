<?php

namespace App\Filament\Resources;

use App\Models\Opd;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OpdResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OpdResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class OpdResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Opd::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'OPD';

    protected static ?string $navigationGroup = 'Manajemen Sistem';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama OPD')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('slug')
                    ->required()
                    ->unique()
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\TextInput::make('domain')
                    ->label('domain')
                    ->helperText('note : Domain digunakan sebagai subdomain website'),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama OPD')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('slug')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Subdomain')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi'),
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
            'index' => Pages\ListOpds::route('/'),
            'create' => Pages\CreateOpd::route('/create'),
            'edit' => Pages\EditOpd::route('/{record}/edit'),
        ];
    }

    // permission apa aja yang dapat dilakukan oleh user akan diatur disini
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
        ];
    }

    // hanya user tertentu yang dapat mengakses opd milik mereka masing-masing
    public static function getEloquentQuery(): Builder
    {
        $user = filament()->auth()->user();

        if ($user && $user->opd_id) {
            return parent::getEloquentQuery()
                ->where('opd_id', $user->opd_id);
        }

        return parent::getEloquentQuery();
    }
}
