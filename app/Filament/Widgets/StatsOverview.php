<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung total pendapatan (Asumsi status 'paid' atau 'confirmed', sesuaikan dengan logic kamu)
        // Kita ambil semua booking, load relasi movie, lalu sum harganya
        $totalRevenue = Booking::where('status', 'success') // Sesuaikan status misal: 'paid', 'success'
            ->with('movie')
            ->get()
            ->sum(fn($booking) => $booking->movie->price);

        return [
            Stat::make('Sudah Check-in', Booking::where('status', 'used')->count())
                ->description('Tiket sudah digunakan')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Tiket Terjual', Booking::count())
                ->description('Total booking berhasil')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),

            Stat::make('Film Tayang', Movie::count())
                ->description('Katalog film saat ini')
                ->descriptionIcon('heroicon-m-film')
                ->color('warning'),

            Stat::make('Pengguna Baru', User::where('role', 'customer')->count())
                ->description('Total customer terdaftar')
                ->descriptionIcon('heroicon-m-users'),
        ];
    }
}
