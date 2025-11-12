<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('wartawan_id')
                    ->label('Wartawan')
                    ->relationship('wartawan', 'nama')
                    ->required()
                    ->preload()
                    ->placeholder('Pilih wartawan'),
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Berita')
                    ->placeholder('Masukkan judul berita')
                    ->helperText('Maksimal 255 karakter.'),
                TextInput::make('ringkasan')
                    ->required()
                    ->maxLength(255)
                    ->label('Ringkasan Berita')
                    ->placeholder('Masukkan ringkasan berita')
                    ->helperText('Maksimal 255 karakter.'),
                RichEditor::make('isi')
                    ->required()
                    ->label('Isi Berita')
                    ->placeholder('Masukkan isi berita'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wartawan.nama')->label('Nama Wartawan')->sortable()->searchable(),
                TextColumn::make('judul')->label('Judul Berita')->sortable()->searchable()->limit(25),
                TextColumn::make('ringkasan')->label('Ringkasan Berita')->limit(25),
                TextColumn::make('isi')->label('Isi Berita')->sortable()->limit(25),
                TextColumn::make('created_at')->label('Tanggal Terbit')->dateTime()->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
