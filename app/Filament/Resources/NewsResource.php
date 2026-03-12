<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
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
                //     ->preload(),
                Forms\Components\Select::make('category_id')
                    ->label('Categori Berita')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query) {

                            $auth = Auth::user();

                            // jika super admin tampilkan semua
                            if (is_null($auth->opd_id)) {
                                return;
                            }

                            // admin opd hanya lihat kategori opd mereka
                            $query->where('opd_id', $auth->opd_id);
                        }
                    ),
                //->relationship('category', 'title'),
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }) // mengisi kolom slug sesuai dengan isian kolom title
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('slug')
                    ->placeholder('Akan otomatis terisi sesuai isi judul')
                    ->readOnly()
                    ->required(),
                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Konten')
                    ->maxLength(5000)
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
                    ->directory('news/' . now()->format('Y-m'))
                    ->reorderable()
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
            // pemisahan data berdasarkan opd id
            // ->modifyQueryUsing(function (builder $query) {
            //     $auth = Auth::user();

            //     // jika super admin, maka tampilkan semua data
            //     if (is_null($auth->opd_id)) {
            //         return;
            //     }

            //     // admin opd
            //     $query->where('opd_id', $auth->opd_id);
            // })
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Categori Berita')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->date('d F Y')
            ])
            ->filters([
                // filter berdasarkan opd
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)), // hanya tampilkan filter jika user adalah super admin

                // filter berdasarkan kategori berita
                SelectFilter::make('category_id')
                    ->label('Filter Kategori')
                    ->relationship(

                        name: 'category',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query) {
                            $auth = Auth::user();

                            // jika role super admin tamilkan semuanya
                            if (is_null($auth->opd_id)) {
                                return;
                            }

                            // jika role admin opd mereka hanya melihat kategori mereka
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
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
