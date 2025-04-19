<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\VisitTindakan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VisitTindakanResource\Pages;
use App\Filament\Resources\VisitTindakanResource\RelationManagers;

class VisitTindakanResource extends Resource
{
    protected static ?string $model = VisitTindakan::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';
    protected static ?string $navigationGroup = 'Dokter';
    protected static ?string $navigationLabel = 'Tindakan Kunjungan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kunjungan_id')
                    ->relationship('kunjungan', 'kode_kunjungan')
                    ->label('Kode Kunjungan')
                    ->required()
                    ->reactive() // Menandakan input ini reaktif
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Ambil tarif dari tindakan yang dipilih
                        $kunjungan = \App\Models\Kunjungan::find($state);

                        if ($kunjungan) {
                            // Set harga berdasarkan tarif tindakan yang dipilih
                            $set('nama_detail_pasien', $kunjungan->pasien->nama_pasien);
                            $set('jenis_detail_kunjungan', $kunjungan->jenis_kunjungan);
                            $set('jenis_detail_keluhan', $kunjungan->keluhan);
                            $set('tanggal_detail_kunjungan', $kunjungan->tanggal_kunjungan);
                        }
                    })
                    ->columnSpan(2),
                Fieldset::make('Detail Kunjungan')
                    ->schema([
                        TextInput::make('nama_detail_pasien')
                            ->label('Nama Pasien')
                            ->disabled(),
                        TextInput::make('jenis_detail_kunjungan')
                            ->label('Jenis Kunjungan')
                            ->disabled(),
                        TextInput::make('jenis_detail_keluhan')
                            ->label('Keluhan')
                            ->disabled(),
                        TextInput::make('tanggal_detail_kunjungan')
                            ->label('Tanggal Kunjungan')
                            ->disabled(),
                    ])
                    ->columns(2),

                Select::make('tindakan_id')
                    ->relationship('tindakan', 'nama_tindakan')
                    ->label('Tindakan')
                    ->required()
                    ->reactive() // Menandakan input ini reaktif
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Ambil tarif dari tindakan yang dipilih
                        $tindakan = \App\Models\Tindakan::find($state);

                        if ($tindakan) {
                            // Set harga berdasarkan tarif tindakan yang dipilih
                            $set('total_harga', $tindakan->tarif);
                        }
                    }),
                TextInput::make('total_harga')
                    ->label('Harga Tindakan')
                    ->dehydrated(true)
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kunjungan.kode_kunjungan')
                    ->label('Kode Kunjungan'),
                TextColumn::make('kunjungan.pasien.nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable(),
                TextColumn::make('kunjungan.tanggal_kunjungan')
                    ->label('Tanggal Kunjungan')
                    ->date()
                    ->sortable(),
                TextColumn::make('tindakan.nama_tindakan')
                    ->label('Tindakan')
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->label('Harga Tindakan')
                    ->money('idr', true)
                    ->sortable(),
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
            'index' => Pages\ListVisitTindakans::route('/'),
            'create' => Pages\CreateVisitTindakan::route('/create'),
            'edit' => Pages\EditVisitTindakan::route('/{record}/edit'),
        ];
    }
}
