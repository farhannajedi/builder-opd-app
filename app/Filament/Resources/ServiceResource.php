<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Layanan OPD';

    protected static ?string $navigationGroup = 'Layanan Publik';

    protected static ?string $modelLabel = 'Layanan';

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
            ->columnSpanFull()
            : Forms\Components\Hidden::make('opd_id')
            ->default($auth->opd_id);

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Layanan Publik')
                    ->description('Kelola daftar layanan publik yang disediakan oleh OPD / Instansi.')
                    ->schema([
                        $opdField,

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Layanan')
                            ->placeholder('Contoh: Layanan Permohonan Informasi Publik (PPID)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Persyaratan Layanan')
                            ->placeholder('Tuliskan rincian persyaratan atau deskripsi singkat layanan...')
                            ->rows(4)
                            ->maxLength(5000)
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
                    ->label('Nama Layanan')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => is_null(Auth::user()->opd_id)),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 60))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Pemilik OPD')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    // Hanya muncul di layar Super Admin (user dengan opd_id null)
                    ->visible(fn() => is_null(Auth::user()->opd_id)),
            ])
            ->defaultSort('created_at', 'desc')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data layanan miliknya, sedangkan super admin melihat semua data
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
