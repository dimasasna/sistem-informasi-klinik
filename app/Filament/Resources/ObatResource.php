<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObatResource\Pages;
use App\Filament\Resources\ObatResource\RelationManagers;
use App\Models\Obat;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObatResource extends Resource
{
    protected static ?string $model = Obat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Admin';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya role dokter yang bisa mengakses resource ini
        return auth()->user()->role === 'admin';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_obat')
                    ->required()
                    ->label('Nama Obat')
                    ->placeholder('Masukkan nama obat'),
                TextInput::make('satuan')
                    ->required()
                    ->label('Satuan')
                    ->placeholder('Masukkan satuan obat'),
                TextInput::make('harga_satuan')
                    ->required()
                    ->label('Harga')
                    ->placeholder('Masukkan harga obat')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1000000)
                    ->step(1000)
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        return 'IDR ' . number_format($state, 2, ',', '.');
                    }),
                TextInput::make('stok')
                    ->required()
                    ->label('Stok')
                    ->placeholder('Masukkan stok obat')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1000000)
                    ->step(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        return number_format($state, 0, ',', '.');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_obat')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('satuan')
                    ->label('Satuan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('harga_satuan')
                    ->label('Harga')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('stok')
                    ->label('Stok')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, ',', '.');
                    }),
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
            'index' => Pages\ListObats::route('/'),
            'create' => Pages\CreateObat::route('/create'),
            'edit' => Pages\EditObat::route('/{record}/edit'),
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
