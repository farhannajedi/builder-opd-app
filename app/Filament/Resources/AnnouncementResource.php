<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pengumuman';

    protected static ?string $modelLabel = 'Pengumuman';

    public static function form(Form $form): Form
    {

        // validasi admin opd
        $auth = Auth::user();

        // menentukan input opd_id berdasarkan role
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
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }), // mengisi kolom slug sesuai dengan isian kolom title
                Forms\Components\TextInput::make('slug')
                    ->label('slug')
                    ->placeholder('Akan otomatis terisi sesuai isi judul')
                    ->readOnly()
                    ->required(),
                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->nullable(),
                Forms\Components\FileUpload::make('images')
                    ->label('Gambar')
                    ->image()
                    ->directory(function (Get $get) use ($auth) {
                        // Jika Admin OPD, gunakan OPD mereka
                        if ($auth->opd_id) {
                            $folderOpd = $auth->opd?->slug ?? 'opd-' . $auth->opd_id;
                        } else {
                            // Jika Super Admin, ambil OPD yang dipilih di form (jika ada)
                            $selectedOpdId = $get('opd_id');
                            $folderOpd = $selectedOpdId ? 'opd-' . $selectedOpdId : 'Admin-Kominfo';
                        }

                        return "Pengumuman/{$folderOpd}/" . now()->format('Y-m-d');
                    })
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Gambar')
                    ->square()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 60))
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default dari tabel
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Rilis')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)), // hanya tampil
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, hanya super admin yang bisa melihat
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
