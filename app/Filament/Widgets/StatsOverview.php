<?php

namespace App\Filament\Widgets;

use DB;
use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Payment;
use App\Models\Tindakan;
use App\Models\Kunjungan;
use App\Models\VisitTindakan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPasien = Pasien::count();
        $totalKunjunganHariIni = Kunjungan::whereDate('created_at', Carbon::today())->count();
        $totalBelumLunas = Payment::where('status', false)->count();

        return [
            Stat::make('Total Pasien', 'users')
                ->label('Total Pasien')
                ->value($totalPasien)
                ->description(description: 'Total pasien saat ini')
                ->icon('heroicon-o-users')
                ->color('success'),
            Stat::make('Kunjungan Hari Ini', 'kunjungan')
                ->label('Kunjungan Hari Ini')
                ->value($totalKunjunganHariIni)
                ->description('Jumlah kunjungan pada tanggal ' . now()->format('d M Y'))
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),
            Stat::make('Belum Terbayar', 'payment')
                ->label('Belum Terbayar')
                ->value($totalBelumLunas)
                ->description('Total pasien yang belum melakukan pembayaran')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
