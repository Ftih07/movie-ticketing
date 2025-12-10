<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Movie $movie)
    {
        // Cek apakah waktu tayang sudah lewat
        if (now()->greaterThan($movie->show_time)) {
            return back()->withErrors(['expired' => 'Jadwal film sudah berakhir.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'movie_id' => $movie->id,
            'ticket_code' => 'TIX-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('booking.ticket', $booking->id);
    }

    public function ticket(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.booking.ticket', compact('booking'));
    }

    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('movie')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.booking.history', compact('bookings'));
    }
}
