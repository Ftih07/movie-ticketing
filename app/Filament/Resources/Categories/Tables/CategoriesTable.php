<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    // Ganti Icon di Resource file (CategoryResource.php), bukan di sini
    // protected static ?string $navigationIcon = 'heroicon-o-tag'; 

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'), // Biar nama kategori lebih tegas

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50) // Membatasi teks jadi 50 karakter biar tabel gak lebar banget
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getState();
                    }) // Kalau di-hover mouse, muncul teks full-nya
                    ->wrap() // Kalau masih panjang, dia turun ke bawah (multiline)
                    ->placeholder('No description provided.') // Kalau kosong ada tulisannya
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i') // Format tanggal lebih enak dibaca (10 Dec 2025, 22:37)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Bisa di-hide dari tombol kolom pojok kanan
            ])
            ->filters([
                // 1. Filter Rentang Tanggal Pembuatan
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Created From'),
                        DatePicker::make('created_until')->label('Created Until'),
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
                    }),

                // 2. Filter untuk cek mana yang deskripsinya masih kosong (Biar gampang maintenancenya)
                Filter::make('empty_description')
                    ->label('Missing Description')
                    ->query(fn(Builder $query): Builder => $query->whereNull('description')->orWhere('description', '')),
            ])
            ->actions([
                EditAction::make()
                    ->iconButton(), // Biar lebih minimalis (opsional)
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc'); // Default urutan paling baru diatas
    }
}
