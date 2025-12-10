<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Movie Ticket App' }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('movies.index') }}" class="font-semibold text-lg">
                MovieTicket
            </a>

            @auth
            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 text-gray-700 hover:text-black font-medium">
                    @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="w-8 h-8 rounded-full object-cover border">
                    @else
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    @endif

                    {{ auth()->user()->name }}
                </a>

                <span class="text-gray-300">|</span> <a href="{{ route('booking.history') }}" class="text-gray-700 hover:text-black">History</a>

                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
            @endauth

            @guest
            <a href="{{ route('user.login') }}" class="text-blue-600 hover:underline">Login</a>
            @endguest
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="max-w-6xl mx-auto p-4">
        {{ $slot }}
    </div>

</body>

</html>