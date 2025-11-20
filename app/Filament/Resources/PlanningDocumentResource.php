<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\PlanningDocument;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlanningDocumentResource\Pages;
use App\Filament\Resources\PlanningDocumentResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class PlanningDocumentResource extends Resource
{
    protected static ?string $model = PlanningDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

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
                // title, content, file
                Forms\Components\Select::make('opd_id')
                    ->label('OPD')
                    ->relationship('opd', 'name')
                    ->preload(),
                Forms\Components\Textarea::make('title')
                    ->label('Judul')
                    ->maxLength(250)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }) // mengisi kolom slug sesuai dengan isian kolom title
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('slug')
                    ->readOnly()
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('Deskripsi')
                    ->maxLength(5000)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->label('File')
                    ->directory('document/' . now()->format('Y-m'))
                    ->downloadable()
                    ->helperText('Maks Size: 1MB')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // pemisahan data berdasarkan opd id
            ->modifyQueryUsing(function (builder $query) {
                $auth = Auth::user();

                // jika super admin, maka tampilkan semua data
                if (is_null($auth->opd_id)) {
                    return;
                }

                // admin opd
                $query->where('opd_id', $auth->opd_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('opd.name')
                    ->label('Nama OPD')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Deskripsi')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
}
