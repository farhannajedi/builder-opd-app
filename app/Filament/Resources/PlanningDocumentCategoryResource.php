<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanningDocumentCategoryResource\Pages;
use App\Models\PlanningDocumentCategory;
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

class PlanningDocumentCategoryResource extends Resource
{
    protected static ?string $model = PlanningDocumentCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Kategori Dokumen';

    protected static ?string $navigationGroup = 'Manajemen Dokumen';

    protected static ?int $navigationSort = 1;

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
            ->required()
            ->live()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                Forms\Components\Section::make('Detail Kategori Dokumen')
                    ->schema([
                        $opdField,

                        Forms\Components\TextInput::make('title')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Rencana Kerja (Renja)')
                            ->live(onBlur: true)
                            ->maxLength(250)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->required(),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->placeholder('Akan otomatis terisi sesuai judul')
                            ->required()
                            ->readOnly()
                            ->dehydrated()
                            ->maxLength(255)
                            ->unique(
                                table: PlanningDocumentCategory::class,
                                column: 'slug',
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, Get $get) use ($auth) {
                                    $opdId = $auth->opd_id ?? $get('opd_id');

                                    return $rule->where('opd_id', $opdId);
                                }
                            ),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Instansi / OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),

                Tables\Columns\TextColumn::make('documents_count')
                    ->counts('documents')
                    ->label('Jumlah Dokumen')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('opd_id')
                    ->label('Filter Instansi')
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
            'index' => Pages\ListPlanningDocumentCategories::route('/'),
            'create' => Pages\CreatePlanningDocumentCategory::route('/create'),
            'edit' => Pages\EditPlanningDocumentCategory::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data kategori dokumen miliknya, sedangkan super admin melihat semua data
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['opd']);

        $user = Auth::user();

        if ($user && $user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
