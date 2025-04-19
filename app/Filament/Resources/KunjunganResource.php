<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Kunjungan;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use function Laravel\Prompts\text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;

use App\Filament\Resources\KunjunganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KunjunganResource\RelationManagers;

class KunjunganResource extends Resource
{
    protected static ?string $model = Kunjungan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square';
    protected static ?string $navigationGroup = 'Petugas Pendafaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                    ->relationship('pasien', 'nama_pasien')
                    ->placeholder('Pilih Pasien')
                    ->label('Pasien')
                    ->required(),
                Select::make('user_id')
                    ->relationship('petugas', 'name')
                    ->label('Petugas')
                    ->default(fn() => Filament::auth()->user()->id)
                    ->disabled()
                    ->dehydrated(),
                DateTimePicker::make('tanggal_kunjungan')
                    ->label('Tanggal Kunjungan')
                    ->required()
                    ->default(now())
                    ->maxDate(now()->addDays(30)),
                Select::make('jenis_kunjungan')
                    ->label('Jenis Kunjungan')
                    ->options([
                        'umum' => 'Umum',
                        'bpjs' => 'BPJS',
                        'rujukan' => 'Rujukan',
                    ])
                    ->required(),
                Textarea::make('keluhan')
                    ->label('Keluhan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_kunjungan')
                    ->label('Kode Kunjungan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pasien.nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_kunjungan')
                    ->label('Jenis Kunjungan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_kunjungan')
                    ->label('Tanggal Kunjungan')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('keluhan')
                    ->label('Keluhan')
                    ->searchable()
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
            'index' => Pages\ListKunjungans::route('/'),
            'create' => Pages\CreateKunjungan::route('/create'),
            'edit' => Pages\EditKunjungan::route('/{record}/edit'),
        ];
    }
}
