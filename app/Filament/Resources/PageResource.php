<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\PageMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationLabel = 'Halaman Kustom';

    protected static ?string $navigationGroup = 'Tambah Halaman OPD';

    protected static ?string $modelLabel = 'Daftar Isi Halaman';

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
                Forms\Components\Section::make('Penempatan Menu & Identitas Halaman')
                    ->schema([
                        $opdField,

                        // Pada method form() di PageResource.php:
                        Forms\Components\Select::make('page_menu_id')
                            ->label('Menu Induk Navbar')
                            ->relationship(
                                name: 'page_menu',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn(Builder $query) => $auth?->opd_id ? $query->where('opd_id', $auth->opd_id) : $query
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Hidden::make('opd_id')->default(fn() => Auth::user()?->opd_id),
                                Forms\Components\TextInput::make('title')
                                    ->label('Nama Menu Baru di Navbar')
                                    ->placeholder('Contoh: Organisasi, Jadwal Kegiatan')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->placeholder('Diisi Secara Otomatis')
                                    ->required()
                                    ->unique(PageMenu::class, 'slug'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Pengantar'),
                            ])
                            ->helperText('Pilih Menu Navbar yang menaungi halaman ini, atau klik (+) untuk buat menu baru.'),

                        Forms\Components\TextInput::make('badge_text')
                            ->label('Teks Label / Badge')
                            ->placeholder('Contoh: KEAGAMAAN, JANUARI 2026')
                            ->required(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul Lengkap Halaman')
                            ->placeholder('Contoh: Organisasi Keagamaan Daerah')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL Halaman')
                            ->placeholder('Akan otomatis terisi')
                            ->required()
                            ->unique(Page::class, 'slug', ignoreRecord: true),

                        Forms\Components\Textarea::make('subtitle')
                            ->label('Ringkasan Singkat (Muncul di Kartu Indeks)')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Jika dinonaktifkan, halaman tidak akan muncul di daftar kartu')
                            ->default(true),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Kartu')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Forms\Components\Section::make('Isi Konten Sub-Halaman')
                    ->schema([
                        Forms\Components\Builder::make('content')
                            ->label('Susunan Blok Konten')
                            ->blocks([
                                Forms\Components\Builder\Block::make('paragraph')
                                    ->label('Teks / Paragraf')
                                    ->schema([
                                        Forms\Components\RichEditor::make('text')->label('Isi Teks')->required(),
                                    ]),

                                Forms\Components\Builder\Block::make('image_block')
                                    ->label('Unggah Gambar')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_url')
                                            ->label('File Gambar')
                                            ->image()
                                            ->directory('page-images')
                                            ->required(),
                                        Forms\Components\TextInput::make('caption')->label('Keterangan Gambar (Caption)'),
                                    ]),

                                Forms\Components\Builder\Block::make('pdf_document')
                                    ->label('Dokumen PDF')
                                    ->schema([
                                        Forms\Components\TextInput::make('doc_title')->label('Nama Dokumen')->required(),
                                        Forms\Components\FileUpload::make('file_path')
                                            ->label('Unggah Berkas PDF')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->directory('page-documents')
                                            ->required(),
                                    ]),
                            ])
                            ->collapsible()
                            ->cloneable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_menu.title')
                    ->label('Menu Induk')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('badge_text')
                    ->label('Badge')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Halaman')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug URL'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status Aktif'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('page_menu_id')
                    ->relationship('page_menu', 'title')
                    ->label('Filter Menu Induk'),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data hero section miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['page_menu', 'opd']);

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
