<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookings extends BaseWidget
{
    protected static ?int $sort = 3; // Paling bawah
    protected int | string | array $columnSpan = 'full'; // Agar lebar tabelnya full

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()->latest()->limit(5) // Ambil 5 transaksi terakhir
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('movie.title')
                    ->label('Film')
                    ->limit(20),
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Kode Tiket')
                    ->copyable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'paid',
                        'success' => 'used', // atau 'paid'
                    ]),
            ]);
    }
}