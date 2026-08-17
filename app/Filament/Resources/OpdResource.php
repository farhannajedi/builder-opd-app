<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpdResource\Pages;
use App\Models\Opd;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OpdResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Opd::class;

    protected static ?string $modelLabel = 'Daftra OPD';

    protected static ?string $pluralModelLabel = 'Daftar OPD';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'OPD / Instansi';

    protected static ?string $navigationGroup = 'Manajemen Sistem';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Instansi / OPD')
                    ->description('Kelola data induk instansi dan slug URL portal.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama OPD')
                            ->placeholder('Contoh: Dinas Komunikasi dan Informatika')
                            ->required()
                            ->maxLength(255),
                        // ->live(onBlur: true),
                        // ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))), ->otomatis membuat slug

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->placeholder('Akan otomatis terisi sesuai Nama OPD')
                            ->required()
                            // ->readOnly()
                            ->dehydrated()
                            ->unique(table: Opd::class, column: 'slug', ignoreRecord: true),

                        // opsional
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Tugas Fungsi')
                            ->placeholder('Tuliskan ringkasan fungsi OPD...')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama OPD')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 50))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Filter berdasarkan ID OPD 
                SelectFilter::make('id')
                    ->label('Filter OPD')
                    ->options(Opd::pluck('name', 'id'))
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
            'index' => Pages\ListOpds::route('/'),
            'create' => Pages\CreateOpd::route('/create'),
            'edit' => Pages\EditOpd::route('/{record}/edit'),
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

    // Admin OPD hanya melihat data instansinya sendiri
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user && $user->opd_id !== null) {
            $query->where('id', $user->opd_id);
        }

        return $query;
    }
}
