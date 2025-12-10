<x-layouts.app :title="$movie->title">

<div class="flex flex-col md:flex-row gap-6">

    <img src="{{ asset('storage/' . $movie->poster) }}"
         class="w-full md:w-1/3 rounded shadow">

    <div class="flex-1">
        <h1 class="text-3xl font-bold">{{ $movie->title }}</h1>

        <p class="text-gray-700 mt-4">{{ $movie->description }}</p>

        <div class="mt-4 text-gray-800">
            <p><strong>Waktu Tayang:</strong> 
               {{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y - H:i') }}
            </p>
            <p><strong>Harga:</strong> Rp {{ number_format($movie->price) }}</p>
        </div>

        @auth
            <form action="{{ route('booking.store', $movie->id) }}" method="POST" class="mt-6">
                @csrf
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Booking Ticket
                </button>
            </form>
        @else
            <div class="mt-6">
                <a href="{{ route('user.login') }}" class="text-blue-600 underline">
                    Login dulu untuk booking
                </a>
            </div>
        @endauth

    </div>
</div>

</x-layouts.app>
