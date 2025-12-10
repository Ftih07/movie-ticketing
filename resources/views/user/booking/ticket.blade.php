<x-layouts.app title="Tiket Anda">

<div class="bg-white p-6 rounded shadow w-full max-w-md mx-auto mt-10">

    <h2 class="text-2xl font-bold text-center mb-4">Tiket Berhasil Dibuat</h2>

    <div class="text-center">
        <p class="font-semibold">Kode Tiket:</p>
        <p class="text-xl font-bold text-blue-700">{{ $booking->ticket_code }}</p>
    </div>

    <div class="mt-6 flex justify-center">
        {!! QrCode::size(180)->generate($booking->ticket_code) !!}
    </div>

    <div class="mt-8">
        <a href="{{ route('booking.history') }}" class="block text-center w-full bg-green-600 text-white py-2 rounded">
            Lihat History Booking
        </a>
    </div>

</div>

</x-layouts.app>
