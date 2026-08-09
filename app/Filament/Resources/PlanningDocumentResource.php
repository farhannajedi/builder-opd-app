<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanningDocumentResource\Pages;
use App\Models\PlanningDocument;
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

class PlanningDocumentResource extends Resource
{
    protected static ?string $model = PlanningDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Arsip Dokumen';

    protected static ?string $navigationGroup = 'Manajemen Dokumen';

    public static function form(Form $form): Form
    {
        $auth = Auth::user();

        // Tentukan input opd_id berdasarkan role user
        $opdField = is_null($auth->opd_id)
            ? Forms\Components\Select::make('opd_id')
            ->label('OPD / Instansi')
            ->relationship('opd', 'name')
            ->searchable()
            ->preload()
            ->reactive()
            ->required()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen Perencanaan')
                    ->schema([
                        $opdField,

                        Forms\Components\Select::make('category_id')
                            ->label('Kategori Dokumen')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'title',
                                modifyQueryUsing: function (Builder $query, Get $get) use ($auth) {
                                    $opdId = $auth->opd_id ?? $get('opd_id');

                                    return $query->when($opdId, fn($q) => $q->where('opd_id', $opdId));
                                }
                            )
                            ->placeholder('Pilih Kategori (Opsional)')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->placeholder('Contoh: Rencana Strategis (Renstra) 2024-2026')
                            ->maxLength(250)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->placeholder('Akan otomatis terisi sesuai judul')
                            ->readOnly()
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label('Deskripsi / Ringkasan Dokumen')
                            ->maxLength(5000)
                            ->columnSpanFull()
                            ->nullable(),
                        Forms\Components\FileUpload::make('file')
                            ->label('Berkas Dokumen (PDF / DOCX)')
                            ->directory('document/files/' . now()->format('Y-m'))
                            ->disk('public')
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(20480) // Maksimal 20MB
                            ->helperText('Format yang diperbolehkan: PDF, DOC, DOCX. Maksimal ukuran: 20MB')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->searchable()
                    ->placeholder('Tanpa Kategori'),
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),
                Tables\Columns\TextColumn::make('content')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 60))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Unggah')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter Kategori')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload(),

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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanningDocuments::route('/'),
            'create' => Pages\CreatePlanningDocument::route('/create'),
            'edit' => Pages\EditPlanningDocument::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data dokumen miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['opd', 'category']);

        $user = Auth::user();

        if ($user && $user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
