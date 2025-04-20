<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasienResource\Pages;
use App\Filament\Resources\PasienResource\RelationManagers;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Petugas Pendafaran';
    public static function shouldRegisterNavigation(): bool
    {
        // Hanya role petugas_pendaftaran yang bisa mengakses resource ini
        return auth()->user()->role === 'petugas_pendaftaran';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_pasien')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(16),
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                Select::make('wilayah_id')
                    ->label('Wilayah')
                    ->relationship('wilayah', 'nama_wilayah') // ini ambil id, tampilkan nama
                    ->preload() // untuk load data dari awal (hindari AJAX jika banyak data)
                    ->required(),
                TextInput::make('telepon')
                    ->label('Telepon')
                    ->maxLength(15)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pasien')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->sortable()
                    ->searchable()
                    ->date(),
                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return $state === 'L' ? 'Laki-laki' : 'Perempuan';
                    }),
                TextColumn::make('wilayah.nama_wilayah')
                    ->label('Alamat')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('telepon')
                    ->label('Telepon')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListPasiens::route('/'),
            'create' => Pages\CreatePasien::route('/create'),
            'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'petugas_pendaftaran';
    }
    public static function canCreate(): bool
    {
        return auth()->user()->role === 'petugas_pendaftaran';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'petugas_pendaftaran';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'petugas_pendaftaran';
    }
}
