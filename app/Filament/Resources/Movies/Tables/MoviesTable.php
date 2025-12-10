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
                    ->searchable(),
                ImageColumn::make('poster')
                    ->square()
                    ->getStateUsing(fn($record) => asset('storage/' . $record->poster)),
                TextColumn::make('price')->money('IDR'),
                TextColumn::make('show_time')
                    ->dateTime()
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
                // 1. Filter Status Tayang (Upcoming vs Past)
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

                // 2. Filter Rentang Tanggal (Dari tanggal X sampai Y)
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
