<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NewsResource\Pages;
use Filament\Tables\Filters\SelectFilter;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $navigationGroup = 'Manajemen Berita';

    protected static ?string $modelLabel = 'Berita';

    public static function form(Form $form): Form
    {
        $auth = Auth::user();

        // Tentukan input untuk opd_id berdasarkan role user
        $opdField = is_null($auth->opd_id)
            ? Forms\Components\Select::make('opd_id')
            ->label('OPD')
            ->relationship('opd', 'name')
            ->searchable()
            ->preload()
            ->required()
            ->live() // Menjadikan live agar dropdown kategori di bawah langsung reaktif menyaring berdasarkan OPD ini
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                $opdField,

                Forms\Components\Select::make('category_id')
                    ->label('Kategori Berita')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query, Get $get) use ($auth) {
                            // Jika Admin OPD, saring berdasarkan OPD
                            if (!is_null($auth->opd_id)) {
                                return $query->where('opd_id', $auth->opd_id);
                            }

                            // Jika Super Admin, saring kategori berdasarkan OPD yang sedang dipilih di form
                            $selectedOpdId = $get('opd_id');
                            if ($selectedOpdId) {
                                return $query->where('opd_id', $selectedOpdId);
                            }
                            return $query;
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Akan otomatis terisi sesuai judul')
                    ->readOnly()
                    ->required(),

                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Konten')
                    ->maxLength(65535)
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('images')
                    ->label('Gambar')
                    ->image()
                    ->directory('news/' . now()->format('Y-m-d'))
                    ->required(),

                Forms\Components\DatePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->displayFormat('d F Y')
                    ->default(today()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),

                // Deskripsi 
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 60))
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),

                SelectFilter::make('category_id')
                    ->label('Filter Kategori')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query) {
                            $auth = Auth::user();

                            if (is_null($auth->opd_id)) {
                                return;
                            }

                            $query->where('opd_id', $auth->opd_id);
                        }
                    )
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data hero section miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['opd', 'category']);

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
