<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilResource\Pages;
use App\Models\Profil;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProfilResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Profil::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Profil Instansi';

    protected static ?string $modelLabel = 'Profil Instansi';

    protected static ?string $pluralModelLabel = 'Profil Instansi';

    protected static ?string $navigationGroup = 'Pengaturan Instansi';

    public static function form(Form $form): Form
    {
        $auth = Auth::user();

        $opdField = is_null($auth->opd_id)
            ? Forms\Components\Select::make('opd_id')
            ->label('OPD / Instansi')
            ->relationship('opd', 'name')
            ->searchable()
            ->preload()
            ->required()
            ->columnSpanFull()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                Forms\Components\Section::make('Identitas OPD')
                    ->schema([
                        $opdField,
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Tanggal Terbit / Pembaharuan')
                            ->default(now())
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Pimpinan & Sambutan')
                    ->description('Masukkan data Kepala Dinas / Pimpinan Instansi beserta foto dan kata sambutannya.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kepala_dinas')
                            ->label('Nama Kepala Dinas / Pimpinan')
                            ->placeholder('Contoh: Dr. H. Ahmad, S.T., M.Si.')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Foto Pimpinan / Kepala Dinas')
                            ->image()
                            ->disk('public')
                            ->directory('profil/pimpinan')
                            ->imageEditor()
                            ->nullable(),
                        Forms\Components\RichEditor::make('sambutan_kepala')
                            ->label('Sambutan Kepala Instansi')
                            ->placeholder('Tuliskan kata sambutan resmi pimpinan...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo'
                            ])
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible(),
                Forms\Components\Section::make('Gambaran Umum & Visi Misi')
                    ->schema([
                        Forms\Components\RichEditor::make('tentang_kami')
                            ->label('Tentang Kami / Gambaran Umum')
                            ->placeholder('Jelaskan ringkasan sejarah dan profil umum instansi...')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('visi')
                            ->label('Visi Instansi')
                            ->placeholder('Tuliskan visi instansi...')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo']),
                        Forms\Components\RichEditor::make('misi')
                            ->label('Misi Instansi')
                            ->placeholder('Tuliskan misi instansi...')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo']),
                    ])->columns(2)->collapsible(),
                Forms\Components\Section::make('Tugas Pokok, Fungsi & Struktur Organisasi')
                    ->schema([
                        Forms\Components\Textarea::make('penjelasan_tugas')
                            ->label('Ringkasan Penjelasan Tugas Utama')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('tugas')
                            ->label('Tugas Utama')
                            ->placeholder('Rincian tugas utama instansi...'),
                        Forms\Components\RichEditor::make('fungsi')
                            ->label('Fungsi Instansi')
                            ->placeholder('Rincian fungsi instansi...'),
                        Forms\Components\FileUpload::make('bagan_struktur')
                            ->label('Bagan / Gambar Struktur Organisasi')
                            ->image()
                            ->disk('public')
                            ->directory('profil/struktur')
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible(),
            ]);
    }

    // Tabel dikembalikan agar fungsi list aktif kembali
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
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Foto Pimpinan')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('nama_kepala_dinas')
                    ->label('Nama Pimpinan')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Terbit')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),
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
        return [];
    }

    // Mengembalikan halaman index, create, dan edit agar struktur aslinya tetap utuh
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfils::route('/'),
            'create' => Pages\CreateProfil::route('/create'),
            'edit' => Pages\EditProfil::route('/{record}/edit'),
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['opd']);
        $user = Auth::user();

        if ($user && $user->opd_id) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
