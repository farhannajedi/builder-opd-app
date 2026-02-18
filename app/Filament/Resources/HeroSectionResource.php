<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HeroSection;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HeroSectionResource\Pages;
use App\Filament\Resources\HeroSectionResource\RelationManagers;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Section::make('Data Hero Section')
                    ->description('Atur judul, slogan, dan status aktif hero banner untuk OPD Anda.')
                    ->schema([
                        Forms\Components\Select::make('opd_id')
                            ->relationship('opd', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('letters')
                            ->label('Huruf Judul (Pisahkan dengan koma)')
                            ->helperText('Masukkan kata-kata yang akan berganti, pisahkan dengan koma. Contoh: "Inovatif,Profesional,Responsif"')
                            ->afterStateHydrated(
                                fn($component, $state) =>
                                $component->state(is_array($state) ? implode(',', $state) : $state)
                            )
                            ->dehydrateStateUsing(fn($state) => array_map('trim', explode(',', $state)))
                            ->nullable(),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('slogan/subjudul')
                            ->helperText('Pisahkan dengan (|)')
                            ->nullable()
                            ->maxLength(500),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktifkan Hero Banner')
                            ->helperText('Pastikan hanya satu hero section yang diaktifkan untuk setiap OPD')
                            ->default(true),
                    ])->columns(2),

                Section::make('koleki banner')
                    ->description('Atur gambar banner yang akan ditampilkan pada hero section. Urutkan sesuai keinginan Anda.')
                    ->schema([
                        Repeater::make('banners')
                            ->relationship('banners')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Gambar Banner')
                                    ->image()
                                    ->directory('hero-banners')
                                    ->imageEditor()
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('order')
                                    ->label('Urutan Tampil')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                            ])
                            ->columns(3)
                            ->grid(2)
                            ->maxItems(4)
                            ->reorderable('order')
                            ->addActionLabel('Tambah Foto Banner'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('OPD')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('banners.image_path')
                    ->label('Banner Utama')
                    ->circular()
                    ->stacked()
                    ->limit(4),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->date('d F Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('opd_id')
                    ->relationship('opd', 'name')
                    ->label('Filter per OPD'),
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
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
