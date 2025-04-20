<?php

namespace App\Filament\Widgets;

use App\Models\VisitObat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UbatChart extends ChartWidget
{
    protected static ?string $heading = 'Obat Terbanyak';
    protected static ?string $description = 'Obat yang paling banyak digunakan';
    protected static ?string $maxHeight = '270px';
    protected static ?string $pollingInterval = '5s';

    protected function getData(): array
    {
        $obatData = VisitObat::select('obat_id', DB::raw('count(*) as total'))
            ->groupBy('obat_id')
            ->with('obat')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $labels = $obatData->pluck('obat.nama_obat');
        $values = $obatData->pluck('total');
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Obat Terbanyak',
                    'data' => $values,
                    'backgroundColor' => ['#a78bfa', '#facc15', '#34d399', '#60a5fa', '#f87171'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'display' => false,  // Menyembunyikan sumbu Y
                ],
            ],
        ];
    }
}
