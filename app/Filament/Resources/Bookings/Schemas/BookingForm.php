<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Select::make('movie_id')
                    ->relationship('movie', 'title')
                    ->searchable()
                    ->required(),

                TextInput::make('ticket_code')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'used' => 'Used',
                    ])
                    ->required(),
            ]);
    }
}
