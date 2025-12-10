<x-layouts.app title="History Booking">

    <h1 class="text-2xl font-bold mb-6">History Booking</h1>

    <div class="space-y-4">

        @foreach ($bookings as $booking)
        <div class="bg-white shadow p-4 rounded flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg">{{ $booking->movie->title }}</h3>
                <p class="text-gray-600">
                    {{ \Carbon\Carbon::parse($booking->movie->show_time)->format('d M Y - H:i') }}
                </p>
                <p class="text-gray-800 mt-1">Kode: {{ $booking->ticket_code }}</p>

                {{-- STATUS BADGE --}}
                <span
                    class="
                        inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full
                        @if($booking->status === 'paid') bg-green-100 text-green-700
                        @else bg-gray-200 text-gray-700
                        @endif
                    ">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <a href="{{ route('booking.ticket', $booking->id) }}"
                class="text-blue-600 underline">
                Lihat
            </a>
        </div>
        @endforeach

    </div>

</x-layouts.app>