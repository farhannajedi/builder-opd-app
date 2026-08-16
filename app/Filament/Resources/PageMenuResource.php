<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageMenuResource\Pages;
use App\Models\PageMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageMenuResource extends Resource
{
    protected static ?string $model = PageMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationLabel = 'Menu Navbar Kustom';

    protected static ?string $navigationGroup = 'Tambah Halaman OPD';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Daftar Halaman Baru';

    public static function form(Form $form): Form
    {
        $auth = Auth::user();

        $opdField = is_null($auth?->opd_id)
            ? Forms\Components\Select::make('opd_id')
            ->label('Organisasi Perangkat Daerah (OPD)')
            ->relationship('opd', 'name')
            ->searchable()
            ->preload()
            ->required()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Menu Navbar')
                    ->schema([
                        $opdField,

                        Forms\Components\TextInput::make('title')
                            ->label('Nama Menu')
                            ->placeholder('Contoh Nama Menu: (Layanan), Publikasi Dokumen')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL Menu')
                            ->placeholder('Akan Diisi Secara Otomatis')
                            ->required()
                            ->unique(PageMenu::class, 'slug', ignoreRecord: true),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat Tentang Menu Ini')
                            ->placeholder('Deskripsi yang muncul di banner saat menu ini dibuka...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Jika Dinonaktifkan, Menu Tidak Akan Tampil Di Menu')
                            ->default(true),

                        // Forms\Components\TextInput::make('order')
                        //     ->label('Urutan Tampil di Navbar')
                        //     ->numeric()
                        //     ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Nama Menu')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug URL'),
                Tables\Columns\TextColumn::make('pages_count')->counts('pages')->label('Jumlah Halaman')->badge(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Status Aktif'),
                // Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
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
            'index' => Pages\ListPageMenus::route('/'),
            'create' => Pages\CreatePageMenu::route('/create'),
            'edit' => Pages\EditPageMenu::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data hero section miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['opd']);

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
