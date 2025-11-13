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
                Forms\Components\TextInput::make('opd_id')
                    ->label('OPD')
                    ->searchable()
                    ->relationship('opd', 'name')
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('logo')
                    ->label('logo')
                    ->image()
                    ->directory('favicons')
                    ->searchable()
                    ->imagePreviewHeight('100'),
                Forms\Components\FileUpload::make('favicon')
                    ->label('Favicon')
                    ->image()
                    ->imageResizeTargetWidth('64')
                    ->imageResizeTargetHeight('64')
                    ->directory('favicons')
                    ->imagePreviewHeight('100')
                    ->nullable(),
                Forms\Components\TextInput::make('address')
                    ->label('Alamat')
                    ->nullable()
                    ->searchable(),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->searchable(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->searchable(),
                Forms\Components\TextInput::make('facebook_url')
                    ->label('Facebook URL')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('instagram_url')
                    ->label('Instagram URL')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('twitter_url')
                    ->label('Twitter URL')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('tiktok_url')
                    ->label('Tiktok URL')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('Youtube URL')
                    ->searchable()
                    ->nullable(),
                Forms\Components\Select::make('homepage_layout')
                    ->label('-')
                    ->nullable()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),
                Tables\Columns\ImageColumn::make('favicon')
                    ->label('Favicon')
                    ->circular(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
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
}
