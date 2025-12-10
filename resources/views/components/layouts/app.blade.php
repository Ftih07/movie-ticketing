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
                    <a href="{{ route('booking.history') }}" class="text-gray-700 hover:text-black">History</a>
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
