<?php

namespace App\Filament\Resources\Movies\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MovieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('duration')
                    ->label('Duration')
                    ->numeric() 
                    ->suffix('Minutes') 
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('poster')
                    ->image()
                    ->disk('public')
                    ->directory('posters'),
                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                TextInput::make('price')
                    ->numeric()
                    ->required(),
                DateTimePicker::make('show_time')
                    ->required(),
            ]);
    }
}
