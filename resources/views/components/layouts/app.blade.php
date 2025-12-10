<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'MOVIEFLIX' }}</title>
    
    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .netflix-gradient {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.7) 50%, rgba(0, 0, 0, 0.9) 100%);
        }

        .netflix-nav-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-black">

    {{-- NAVBAR - Netflix Style --}}
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 netflix-gradient netflix-nav-shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('movies.index') }}" class="font-bold text-2xl sm:text-3xl text-red-600 hover:text-red-500 transition tracking-tight">
                MOVIEFLIX
            </a>

            @auth
            <div class="flex items-center gap-3 sm:gap-6">
                <a href="{{ route('booking.history') }}" class="text-gray-300 hover:text-white transition text-sm sm:text-base font-medium">
                    My List
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 sm:gap-3 text-gray-300 hover:text-white font-medium transition group">
                    @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded object-cover border-2 border-transparent group-hover:border-white transition">
                    @else
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded bg-red-600 flex items-center justify-center text-sm font-bold border-2 border-transparent group-hover:border-white transition">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    @endif

                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                </a>

                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button class="text-gray-400 hover:text-red-500 transition text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
            @endauth

            @guest
            <a href="{{ route('user.login') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 sm:px-6 py-2 rounded font-semibold transition text-sm sm:text-base">
                Sign In
            </a>
            @endguest
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="pt-20 min-h-screen">
        {{ $slot }}
    </div>

    {{-- FOOTER - Netflix Style --}}
    <footer class="bg-black border-t border-gray-900 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p class="mb-2">Questions? Contact us.</p>
                <p>&copy; 2025 MovieFlix. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>