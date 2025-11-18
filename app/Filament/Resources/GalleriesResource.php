<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Galleries;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\FormsComponent;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\GalleriesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GalleriesResource\RelationManagers;
use App\Filament\Resources\GalleriesResource\Pages\EditGalleries;
use App\Filament\Resources\GalleriesResource\Pages\ListGalleries;
use App\Filament\Resources\GalleriesResource\Pages\CreateGalleries;

class GalleriesResource extends Resource
{
    protected static ?string $model = Galleries::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // ini adalah validasi, agar admin opd tidak dapat memilih opd, namun otomatis terisi berdasarkan user->opd id
        $auth = Auth::user();

        // Tentukan input untuk opd_id berdasarkan role user
        $opdField = is_null($auth->opd_id)
            ? Forms\Components\Select::make('opd_id')
            ->label('OPD')
            ->relationship('opd', 'name')
            ->searchable()
            ->preload()
            ->required()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                $opdField,
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
            // pemisahan data berdasarkan opd id
            ->modifyQueryUsing(function (builder $query) {
                $auth = Auth::user();

                // jika super admin, maka tampilkan semua data
                if (is_null($auth->opd_id)) {
                    return;
                }

                // admin opd
                $query->where('opd_id', $auth->opd_id);
            })
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
