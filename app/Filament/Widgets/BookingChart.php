<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingChart extends ChartWidget
{
    protected ?string $heading = 'Tren Penjualan Tiket Bulanan';
    protected static ?int $sort = 2;

    // --- TAMBAHKAN BARIS INI ---
    protected int | string | array $columnSpan = 'full';
    // ---------------------------

    protected function getData(): array
    {
        // 1. Ambil data per bulan tahun ini
        $data = Booking::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // 2. Siapkan array kosong 1-12 bulan biar grafik gak bolong
        $counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $counts[] = $data[$i] ?? 0;
        }

        // 3. Label bulan
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return [
            'datasets' => [
                [
                    'label' => 'Tiket Terjual',
                    'data' => $counts,
                    'borderColor' => '#F59E0B',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
