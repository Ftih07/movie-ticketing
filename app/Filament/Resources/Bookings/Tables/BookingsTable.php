<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('movie.title')
                    ->label('Movie')
                    ->sortable(),
                TextColumn::make('ticket_code')
                    ->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')  
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // 1. Filter Berdasarkan Film (Relasi)
                // Ini otomatis ngambil daftar film dari database
                SelectFilter::make('movie_id')
                    ->label('Filter Film')
                    ->relationship('movie', 'title')
                    ->searchable()
                    ->preload(),

                // 2. Filter Status Tiket
                SelectFilter::make('status')
                    ->label('Status Tiket')
                    ->options([
                        'paid' => 'Paid (Belum Dipakai)',
                        'used' => 'Used (Sudah Ditonton)',
                    ]),

                // 3. Filter Tanggal Transaksi
                Filter::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->form([
                        DatePicker::make('created_from')->label('Dari Tanggal'),
                        DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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
