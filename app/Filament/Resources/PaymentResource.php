<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Pembayaran';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya role dokter yang bisa mengakses resource ini
        return auth()->user()->role === 'kasir';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kunjungan.kode_kunjungan')->label('Kode Kunjungan')->sortable()->searchable(),
                TextColumn::make('kunjungan.pasien.nama_pasien')->label('Nama Pasien')->sortable()->searchable(),
                TextColumn::make('total_tagihan')->label('Total Tagihan')->money('IDR', true),
                TextColumn::make('metode_pembayaran')->label('Metode'),
                IconColumn::make('status')->boolean()->label('Dibayar'),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($record) => $record->status ? 'Lunas' : 'Belum Bayar')
                    ->badge()
                    ->color(fn($record) => $record->status ? 'success' : 'danger')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Bayar')
                    ->label('Bayar')
                    ->icon('heroicon-o-archive-box-x-mark')
                    ->color('success')
                    ->visible(fn($record) => !$record->status)
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalSubheading(fn($record) => 'Detail Tagian Pasien ')
                    ->modalContent(fn($record) => new HtmlString('
                        <div class="space-y-2 border p-4 rounded-lg">
                            <p><strong>Nama Pasien:</strong> ' . $record->kunjungan->pasien->nama_pasien . '</p>
                            <p><strong>Kode Kunjungan:</strong> ' . $record->kunjungan->kode_kunjungan . '</p>
                            <p><strong>Tindakan:</strong> ' . implode(', ', $record->kunjungan->visitTindakan->pluck('tindakan.nama_tindakan')->toArray()) . '</p>
                            <p><strong>Obat:</strong> ' . implode(', ', $record->kunjungan->visitObat->pluck('obat.nama_obat')->toArray()) . '</p>

                            <p><strong>Total:</strong> Rp' . number_format($record->total_tagihan, 0, ',', '.') . '</p>
                        </div>'))
                    ->form([
                        Select::make('metode_pembayaran')
                            ->options([
                                'cash' => 'Cash',
                                'debit' => 'Debit',
                                'transfer' => 'Transfer',
                            ])
                            ->label('Metode Pembayaran')
                            ->required(),
                    ])

                    ->action(function (array $data, $record) {
                        $record->update([
                            'metode_pembayaran' => $data['metode_pembayaran'],
                            'status' => true,
                        ]);

                        Notification::make()
                            ->title('Pembayaran berhasil')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'kasir';
    }
    public static function canCreate(): bool
    {
        return auth()->user()->role === 'kasir';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'kasir';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->role === 'kasir';
    }
}
