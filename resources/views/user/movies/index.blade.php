<x-layouts.app title="Pilih Film">

<h1 class="text-2xl font-bold mb-6">Pilih Film</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

    @foreach ($movies as $movie)
        <a href="{{ route('movies.show', $movie->id) }}" class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">
            <img src="{{ asset('storage/' . $movie->poster) }}"
                 class="w-full h-60 object-cover">

            <div class="p-4">
                <h2 class="font-semibold text-lg">{{ $movie->title }}</h2>
                <p class="text-gray-600 text-sm mt-1">
                    {{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y - H:i') }}
                </p>
                <p class="text-blue-600 font-semibold mt-2">Rp {{ number_format($movie->price) }}</p>
            </div>
        </a>
    @endforeach

</div>

</x-layouts.app>
