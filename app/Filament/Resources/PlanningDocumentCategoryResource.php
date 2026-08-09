<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanningDocumentCategoryResource\Pages;
use App\Models\PlanningDocumentCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PlanningDocumentCategoryResource extends Resource
{
    protected static ?string $model = PlanningDocumentCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kategori Dokumen';

    protected static ?int $navigationSort = 1;

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
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->placeholder('Contoh: Rencana Kerja')
                    ->live(onBlur: true)
                    ->maxLength(250)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }) // mengisi kolom slug sesuai dengan isian kolom title
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),
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

                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Instansi / OPD')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

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
            ->filters([
                Tables\Filters\SelectFilter::make('opd_id')
                    ->relationship('opd', 'name')
                    ->label('Filter Instansi')
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
            'index' => Pages\ListPlanningDocumentCategories::route('/'),
            'create' => Pages\CreatePlanningDocumentCategory::route('/create'),
            'edit' => Pages\EditPlanningDocumentCategory::route('/{record}/edit'),
        ];
    }

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
