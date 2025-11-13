<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\NewsCategories;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsCategoriesResource\Pages;
use App\Filament\Resources\NewsCategoriesResource\RelationManagers;

class NewsCategoriesResource extends Resource
{
    protected static ?string $model = NewsCategories::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('opd_id')
                    ->label('OPD'),
                Forms\Components\TextInput::make('title')
                    ->label('Nama Kategori Berita')
                    ->placeholder('Masukkan nama kategori untuk berita anda...')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }) // mengisi kolom slug sesuai dengan isian kolom title
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Akan otomatis terisi sesuai judul')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
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
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('slug')
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y'),
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
            'index' => Pages\ListNewsCategories::route('/'),
            'create' => Pages\CreateNewsCategories::route('/create'),
            'edit' => Pages\EditNewsCategories::route('/{record}/edit'),
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
