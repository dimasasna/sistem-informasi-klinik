<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\VisitObat;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VisitObatResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VisitObatResource\RelationManagers;

class VisitObatResource extends Resource
{
    protected static ?string $model = VisitObat::class;

    protected static ?string $navigationIcon = 'heroicon-o-link-slash';
    protected static ?string $navigationGroup = 'Dokter';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kunjungan_id')
                    ->relationship('kunjungan', 'kode_kunjungan')
                    ->label('Kode Kunjungan')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $kunjungan = \App\Models\Kunjungan::find($state);

                        if ($kunjungan) {
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
                //
                Select::make('obat_id')
                            ->relationship('obat', 'nama_obat')
                            ->label('Nama Obat')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $obat = \App\Models\Obat::find($state);
                                if ($obat) {
                                    $set('harga_satuan', $obat->harga_satuan);
                                }
                            }),
                        TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->dehydrated(true)
                            ->disabled()
                            ->reactive()
                            ->prefix('IDR '),

                        TextInput::make('qty')
                            ->label('Jumlah Obat')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->step(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $hargaSatuan = $get('harga_satuan');
                                $totalHargaObat = $state * $hargaSatuan;
                                $set('total_harga', $totalHargaObat);
                            }),

                        TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->dehydrated(true)
                            ->readOnly()
                            ->reactive()
                            ->prefix('IDR '),

                // TextInput::make('total_harga')
                //     ->placeholder(function ($set,  $get) {
                //         $totalHarga = collect($get('Resep Obat'))->pluck('total_harga_obat')->sum();
                //         if ($totalHarga == null) {
                //             $set('total_harga', 0);
                //         } else {
                //             $set('total_harga', $totalHarga);
                //         }
                //     })
                //     ->label('Total Harga')
                //     ->dehydrated(true)
                //     ->readOnly()
                //     ->reactive()
                //     ->prefix('IDR '),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kunjungan.kode_kunjungan')
                    ->label('Kode Kunjungan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('obat.nama_obat')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('qty')
                    ->label('Jumlah Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('obat.harga_satuan')
                    ->label('Harga Satuan')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR', true)
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
            'index' => Pages\ListVisitObats::route('/'),
            'create' => Pages\CreateVisitObat::route('/create'),
            'edit' => Pages\EditVisitObat::route('/{record}/edit'),
        ];
    }

}
