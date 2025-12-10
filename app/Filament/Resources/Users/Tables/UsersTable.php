<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Kolom No Urut (Opsional)
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                // 2. Kolom Foto Profil
                ImageColumn::make('profile_image')
                    ->circular() // Biar bunder
                    ->label('Avatar')
                    ->disk('public') // Pastikan ambil dari disk public
                    ->getStateUsing(fn($record) => asset('storage/' . $record->profile_image)),

                // 3. Kolom Nama
                TextColumn::make('name')
                    ->searchable() // Biar bisa dicari
                    ->sortable()
                    ->weight('bold'),

                // 4. Kolom Email
                TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope'),

                // 5. Kolom Role (Pake Badge biar keren)
                TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',   // Merah buat admin
                        'customer' => 'info',  // Biru buat customer
                        default => 'gray',
                    }),

                // 6. Tanggal Join (Register)
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Joined Date')
                    ->sortable(),
            ])
            ->filters([
                // Kalau mau filter berdasarkan Role
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                    ]),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                    BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
