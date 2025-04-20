<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms;
use Filament\Tables;
use App\Models\Tindakan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TindakanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TindakanResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class TindakanResource extends Resource
{
    protected static ?string $model = Tindakan::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Admin';
    public static function shouldRegisterNavigation(): bool
    {
        // Hanya role admin yang bisa mengakses resource ini
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_tindakan')
                    ->required()
                    ->label('Nama Tindakan')
                    ->placeholder('Masukkan nama tindakan')
                    ->columnSpan(2),
                Textarea::make('deskripsi')
                    ->required()
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi tindakan')
                    ->columnSpan(2),
                TextInput::make('tarif')
                    ->required()
                    ->label('Tarif')
                    ->placeholder('Masukkan tarif tindakan')
                    ->numeric()
                    ->minValue(0)
                    ->step(1000)
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        return 'IDR ' . number_format($state, 2, ',', '.');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_tindakan')
                    ->label('Nama Tindakan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tarif')
                    ->label('Tarif')
                    ->money('IDR', true)
                    ->sortable(),
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
            'index' => Pages\ListTindakans::route('/'),
            'create' => Pages\CreateTindakan::route('/create'),
            'edit' => Pages\EditTindakan::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }
    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }
}
