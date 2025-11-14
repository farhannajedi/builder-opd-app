<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\OpdConfigs;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OpdConfigsResource\Pages;
use App\Filament\Resources\OpdConfigsResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class OpdConfigsResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = OpdConfigs::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('opd_id')
                    ->label('OPD')
                    ->relationship('opd', 'name')
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('logo')
                    ->label('logo')
                    ->image(),
                Forms\Components\FileUpload::make('favicon')
                    ->label('Favicon')
                    ->image()
                    ->nullable(),
                Forms\Components\TextInput::make('address')
                    ->label('Alamat')
                    ->nullable(),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('facebook_url')
                    ->label('Facebook URL')
                    ->nullable(),
                Forms\Components\TextInput::make('instagram_url')
                    ->label('Instagram URL')
                    ->nullable(),
                Forms\Components\TextInput::make('twitter_url')
                    ->label('Twitter URL')
                    ->nullable(),
                Forms\Components\TextInput::make('tiktok_url')
                    ->label('Tiktok URL')
                    ->nullable(),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('Youtube URL')
                    ->nullable(),
                Forms\Components\Select::make('homepage_layout')
                    ->label('-')
                    ->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public'),
                Tables\Columns\ImageColumn::make('favicon')
                    ->label('Favicon')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('facebook_url')
                    ->label('Facebook'),
                Tables\Columns\TextColumn::make('instagram_url')
                    ->label('Instagram'),
                Tables\Columns\TextColumn::make('twitter_url')
                    ->label('Twitter'),
                Tables\Columns\TextColumn::make('youtube_url')
                    ->label('Youtube'),
                Tables\Columns\TextColumn::make('homepage_layout')
                    ->label('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
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
            'index' => Pages\ListOpdConfigs::route('/'),
            'create' => Pages\CreateOpdConfigs::route('/create'),
            'edit' => Pages\EditOpdConfigs::route('/{record}/edit'),
        ];
    }

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
