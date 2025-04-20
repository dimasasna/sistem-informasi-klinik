<?php

namespace App\Filament\Widgets;

use App\Models\VisitTindakan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TindakanChart extends ChartWidget
{
    protected static ?string $heading = 'Tindakan Terbanyak';
    protected static ?string $description = 'Tindakan yang paling banyak dilakukan';
    protected static ?string $maxHeight = '400px';
    protected static ?string $pollingInterval = '5s';

    protected function getData(): array
    {
        $tindakanData = VisitTindakan::select('tindakan_id', DB::raw('count(*) as total'))
            ->groupBy('tindakan_id')
            ->with('tindakan')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $labels = $tindakanData->pluck('tindakan.nama_tindakan');
        $values = $tindakanData->pluck('total');
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Tindakan Terbanyak',
                    'data' => $values,
                    'backgroundColor' => ['#f87171', '#60a5fa', '#34d399', '#facc15', '#a78bfa'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
