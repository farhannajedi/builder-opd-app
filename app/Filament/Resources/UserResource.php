<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Daftar Pengguna';

    protected static ?string $pluralModelLabel = 'Daftar Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $navigationGroup = 'Manajemen Sistem';

    public static function form(Form $form): Form
    {

        // testing agar yang bisa mengubah hanya super admin
        $user = Auth::user();
        $isSuperAdmin = is_null($user->opd_id);

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    // ->required(fn($record) => $record === null) // wajib isi saat create
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state)) // hanya update jika diisi
                    ->helperText('Isi password hanya jika ingin mengubah.'),
                Forms\Components\Select::make('opd_id')
                    ->label('OPD')
                    ->relationship('opd', 'name')
                    ->preload('false')
                    ->visible($isSuperAdmin) // Hilang dari form jika bukan super admin
                    ->searchable(),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->label('Role')
                    ->preload('false')
                    ->searchable()
                    ->visible($isSuperAdmin), // Hilang dari form jika bukan super admin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('OPD'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->sortable()
                    ->dateTime('d M Y'),
            ])
            ->filters([
                // filter bersarkan opd
                SelectFilter::make('opd_id')
                    ->label('Filter OPD')
                    ->relationship('opd', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => is_null(Auth::user()->opd_id)), // hanya tampilkan filter jika user adalah super admin
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'opd',
                'roles',
            ]);
    }
}
