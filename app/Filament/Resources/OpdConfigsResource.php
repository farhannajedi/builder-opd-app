<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpdConfigsResource\Pages;
use App\Models\OpdConfigs;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OpdConfigsResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = OpdConfigs::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Pengaturan OPD';

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
                Forms\Components\Section::make('Identitas & Kontak OPD')
                    ->description('Atur identitas utama, logo, serta kontak resmi instansi.')
                    ->schema([
                        $opdField,

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Resmi OPD')
                            ->image()
                            ->disk('public')
                            ->directory('opd-configs/logos')
                            ->nullable(),
                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon Website')
                            ->image()
                            ->disk('public')
                            ->directory('opd-configs/favicons')
                            ->nullable(),
                        Forms\Components\TextInput::make('address')
                            ->label('Alamat Kantor')
                            ->placeholder('Jl. Jendral Sudirman No...')
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon Kantor')
                            ->tel()
                            ->placeholder('0777-xxxxx'),
                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email Resmi')
                            ->email()
                            ->placeholder('nama-dinas@karimunkab.go.id'),
                    ])->columns(2),

                Forms\Components\Section::make('Tautan Media Sosial')
                    ->description('Masukkan tautan akun media sosial resmi instansi.')
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->placeholder('https://facebook.com/...')
                            ->nullable(),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/...')
                            ->nullable(),
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('X / Twitter URL')
                            ->url()
                            ->placeholder('https://x.com/...')
                            ->nullable(),
                        Forms\Components\TextInput::make('tiktok_url')
                            ->label('TikTok URL')
                            ->url()
                            ->placeholder('https://tiktok.com/@...')
                            ->nullable(),
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube Channel URL')
                            ->url()
                            ->placeholder('https://youtube.com/@...')
                            ->nullable(),
                    ])->columns(2)->collapsible(),
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
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->square()
                    ->disk('public'),
                Tables\Columns\ImageColumn::make('favicon')
                    ->label('Favicon')
                    ->square()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook_url')
                    ->label('Facebook')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('instagram_url')
                    ->label('Instagram')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('twitter_url')
                    ->label('Twitter / X')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('youtube_url')
                    ->label('YouTube')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListOpdConfigs::route('/'),
            'create' => Pages\CreateOpdConfigs::route('/create'),
            'edit' => Pages\EditOpdConfigs::route('/{record}/edit'),
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

    // pembatasan data berdasarkan opd id, agar admin opd hanya melihat data hero section miliknya, sedangkan super admin melihat semua data
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
