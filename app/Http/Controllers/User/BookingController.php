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

        return redirect()->route('booking.ticket', $booking);
    }

    public function ticket(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.booking.ticket', compact('booking'));
    }

    public function history(Request $request)
    {
        // 1. Mulai Query dasar (Punya user yang login)
        $query = Booking::where('user_id', Auth::id())->with('movie');

        // 2. LOGIKA SEARCH (Bisa cari Kode Tiket ATAU Judul Film)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari berdasarkan Ticket Code
                $q->where('ticket_code', 'like', '%' . $search . '%')
                    // ATAU Cari berdasarkan Judul Film (Relasi)
                    ->orWhereHas('movie', function ($mq) use ($search) {
                        $mq->where('title', 'like', '%' . $search . '%');
                    });
            });
        }

        // 3. LOGIKA FILTER & SORT
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc'); // Tanggal Lama
                    break;
                case 'status_paid':
                    $query->where('status', 'paid')->orderBy('created_at', 'desc');
                    break;
                case 'status_used':
                    $query->where('status', 'used')->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc'); // Default: Terbaru
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default tanpa filter
        }

        $bookings = $query->paginate(5); 

        return view('user.booking.history', compact('bookings'));
    }
}
