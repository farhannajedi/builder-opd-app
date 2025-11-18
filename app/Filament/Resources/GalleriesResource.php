<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Galleries;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GalleriesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GalleriesResource\RelationManagers;

class GalleriesResource extends Resource
{
    protected static ?string $model = Galleries::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('opd_id')
                    ->label('OPD')
                    ->relationship('opd', 'name'),
                Forms\Components\TextInput::make('title')
                    ->label('Judul'),
                // ->afterStateUpdated(function ($state, callable $set) {
                //     $set('slug', Str::slug($state));
                // }), // mengisi kolom slug sesuai dengan isian kolom title
                Forms\Components\FileUpload::make('images')
                    ->label('Gambar')
                    ->image()
                    ->nullable(),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(5000)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Gambar')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('deskripsi')
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGalleries::route('/create'),
            'edit' => Pages\EditGalleries::route('/{record}/edit'),
        ];
    }
}
