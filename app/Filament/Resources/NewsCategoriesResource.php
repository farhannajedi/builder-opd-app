<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsCategoriesResource\Pages;
use App\Models\NewsCategories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsCategoriesResource extends Resource
{
    protected static ?string $model = NewsCategories::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Kategori Berita';

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
                // Forms\Components\Select::make('opd_id')
                //     ->label('OPD')
                //     ->relationship('opd', 'name')
                //     ->preload()
                //     ->dehydrated(),
                // ->default(fn() => filament()->auth()->user()->opd_id)
                // ->hidden(fn() => !filament()->auth()->user()->hasRole('super admin')),
                //->options(
                //     filament()->auth()->user()->hasRole('super admin')
                //         ? \App\Models\Opd::pluck('name', 'id')
                //         : \App\Models\Opd::where('id', filament()->auth()->user()->opd_id)->pluck('name', 'id')
                // )
                // ->disabled(!filament()->auth()->user()->hasRole('admin BPKAD')),
                Forms\Components\TextInput::make('title')
                    ->label('Nama Kategori Berita')
                    ->placeholder('Masukkan nama kategori untuk berita anda....')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }) // mengisi kolom slug sesuai dengan isian kolom title
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Akan otomatis terisi sesuai isi judul')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->unique(
                        table: NewsCategories::class,
                        column: 'slug',
                        ignoreRecord: true,
                        modifyRuleUsing: fn($rule) =>
                        $rule->where('opd_id', Auth::user()->opd_id)
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // pemisahan data berdasarkan opd id
            // ->modifyQueryUsing(function (Builder $query) {
            //     $auth = Auth::user();

            //     // jika super admin, maka tampilkan semua data
            //     if (is_null($auth->opd_id)) {
            //         return;
            //     }

            //     // jika admin opd
            //     $query->where('opd_id', $auth->opd_id);
            // })
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
                // filter berdasarkan opd
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)), // hanya tampilkan filter jika user adalah super admin
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

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data hero section miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
