<?php

namespace App\Filament\Resources\Movies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class MoviesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'), // Sedikit dipertebal biar jelas judulnya

                ImageColumn::make('poster')
                    ->square()
                    ->getStateUsing(fn($record) => asset('storage/' . $record->poster)),

                // --- BAGIAN KATEGORI (MODIFIKASI DISINI) ---
                TextColumn::make('categories.name') // Mengambil nama dari relasi categories
                    ->label('Genres')
                    ->badge() // Membuat tampilan seperti "Tags" kotak-kotak
                    ->separator(',') // Jika badge tidak muat, dipisah koma (opsional)
                    ->color('warning') // Warna badge (bisa primary, success, danger, warning, dll)
                    ->limitList(2) // Kalau kategorinya ada 10, cuma tampil 2 + "2 more" (biar tabel gak panjang ke bawah)
                    ->searchable(),

                TextColumn::make('duration')
                    ->numeric()
                    ->suffix(' Minutes')
                    ->sortable(),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('show_time')
                    ->dateTime('d M Y, H:i') // Format tanggal dipercantik
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // --- FILTER KATEGORI (MODIFIKASI DISINI) ---
                // Ini otomatis mencari kategori yang tersedia di database
                SelectFilter::make('categories')
                    ->label('Filter by Genre')
                    ->relationship('categories', 'name') // Relasi ke categories, ambil kolom name
                    ->searchable()
                    ->preload()
                    ->multiple(), // Biar bisa filter "Horror" DAN "Comedy" sekaligus

                // 1. Filter Status Tayang
                SelectFilter::make('status_tayang')
                    ->label('Status Tayang')
                    ->options([
                        'upcoming' => 'Akan Tayang (Upcoming)',
                        'past' => 'Sudah Lewat (Past)',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'upcoming') {
                            return $query->where('show_time', '>=', now());
                        }
                        if ($data['value'] === 'past') {
                            return $query->where('show_time', '<', now());
                        }
                    }),

                // 2. Filter Rentang Tanggal
                Filter::make('show_time')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('show_time', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('show_time', '<=', $date),
                            );
                    })
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
