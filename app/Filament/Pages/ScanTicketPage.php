<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Booking;
use Filament\Notifications\Notification;

class ScanTicketPage extends Page
{
    // Use the exact union type that matches Filament v4 parent
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';
    
    protected static ?string $navigationLabel = 'Scan Ticket';
    protected static ?string $title = 'Scan Ticket';

    protected string $view = 'filament.pages.scan-ticket-page';

    // Livewire state
    public ?Booking $booking = null;
    public string $ticket = '';

    // AUTO VALIDATE whenever ticket changes
    public function updatedTicket()
    {
        $this->validateTicket();
    }

    public function validateTicket()
    {
        if (! $this->ticket) {
            $this->booking = null;
            return;
        }

        $this->booking = Booking::where('ticket_code', $this->ticket)
            ->with('movie')
            ->first();

        if (! $this->booking) {
            Notification::make()
                ->title('Ticket not found')
                ->danger()
                ->send();
            return;
        }

        Notification::make()
            ->title('Ticket Valid')
            ->success()
            ->send();
    }

    public function markAsUsed()
    {
        if (! $this->booking) return;

        $this->booking->update(['status' => 'used']);

        Notification::make()
            ->title('Ticket marked as USED')
            ->success()
            ->send();
    }
}
