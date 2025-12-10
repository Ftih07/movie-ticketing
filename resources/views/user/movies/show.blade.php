<x-layouts.app :title="$movie->title">

    <div class="bg-black min-h-screen text-white">

        {{-- Hero Section with Background --}}
        <div class="relative h-[60vh] sm:h-[70vh] lg:h-[80vh] overflow-hidden">

            {{-- Background Image with Overlay --}}
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $movie->poster) }}"
                    class="w-full h-full object-cover"
                    alt="{{ $movie->title }}">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/50"></div>
            </div>

            {{-- Content --}}
            <div class="relative h-full flex items-end pb-12 sm:pb-16 lg:pb-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl">

                        {{-- Title --}}
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                            {{ $movie->title }}
                        </h1>

                        {{-- Meta Info --}}
                        <div class="flex flex-wrap items-center gap-4 mb-6 text-sm sm:text-base">
                            <div class="flex items-center gap-2 bg-black/50 backdrop-blur-sm px-3 py-1.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-300">{{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y - H:i') }} WIB</span>
                            </div>

                            <div class="flex items-center gap-2 bg-red-600/20 backdrop-blur-sm border border-red-600/50 px-4 py-1.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-bold text-white">Rp {{ number_format($movie->price) }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        @auth
                        <form action="{{ route('booking.store', $movie->id) }}" method="POST">
                            @csrf
                            <button class="bg-white hover:bg-gray-200 text-black font-bold px-8 sm:px-10 py-3 sm:py-4 rounded-lg text-base sm:text-lg transition shadow-2xl hover:scale-105 transform inline-flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                Book Ticket Now
                            </button>
                        </form>
                        @else
                        <a href="{{ route('user.login') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 sm:px-10 py-3 sm:py-4 rounded-lg text-base sm:text-lg transition shadow-2xl hover:scale-105 transform inline-flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Sign In to Book
                        </a>
                        @endauth

                    </div>
                </div>
            </div>
        </div>

        {{-- Movie Details Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- Poster Card --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="rounded-lg overflow-hidden shadow-2xl border border-gray-800">
                            <img src="{{ asset('storage/' . $movie->poster) }}"
                                class="w-full h-auto"
                                alt="{{ $movie->title }}">
                        </div>

                        {{-- Quick Info Cards --}}
                        <div class="mt-6 space-y-3">
                            <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm">Showtime</span>
                                    <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($movie->show_time)->format('H:i') }} WIB</span>
                                </div>
                            </div>

                            <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm">Date</span>
                                    <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="bg-red-600/10 backdrop-blur-sm border border-red-600/30 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm">Price</span>
                                    <span class="text-red-500 font-bold text-lg">Rp {{ number_format($movie->price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description & Info --}}
                <div class="lg:col-span-2">
                    <div class="space-y-8">

                        {{-- Synopsis --}}
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Synopsis</h2>
                            <div class="bg-gray-900/30 backdrop-blur-sm border border-gray-800 rounded-lg p-6">
                                <p class="text-gray-300 leading-relaxed text-base sm:text-lg">
                                    {{ $movie->description }}
                                </p>
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Movie Information</h2>
                            <div class="bg-gray-900/30 backdrop-blur-sm border border-gray-800 rounded-lg p-6">
                                <dl class="space-y-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center border-b border-gray-800 pb-4">
                                        <dt class="text-gray-400 sm:w-1/3 mb-1 sm:mb-0">Title</dt>
                                        <dd class="text-white font-semibold sm:w-2/3">{{ $movie->title }}</dd>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center border-b border-gray-800 pb-4">
                                        <dt class="text-gray-400 sm:w-1/3 mb-1 sm:mb-0">Show Date & Time</dt>
                                        <dd class="text-white font-semibold sm:w-2/3">{{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y - H:i') }} WIB</dd>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <dt class="text-gray-400 sm:w-1/3 mb-1 sm:mb-0">Ticket Price</dt>
                                        <dd class="text-red-500 font-bold text-lg sm:w-2/3">Rp {{ number_format($movie->price) }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        {{-- CTA Section --}}
                        @auth
                        <div class="bg-gradient-to-r from-red-600/20 to-red-600/10 backdrop-blur-sm border border-red-600/30 rounded-lg p-6 sm:p-8">
                            <h3 class="text-xl sm:text-2xl font-bold mb-3">Ready to Watch?</h3>
                            <p class="text-gray-300 mb-6">Book your ticket now and enjoy this amazing movie!</p>
                            <form action="{{ route('booking.store', $movie->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-lg transition shadow-lg hover:shadow-red-500/50 inline-flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    Book This Movie
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="bg-gradient-to-r from-gray-900/50 to-gray-900/30 backdrop-blur-sm border border-gray-800 rounded-lg p-6 sm:p-8">
                            <h3 class="text-xl sm:text-2xl font-bold mb-3">Sign In Required</h3>
                            <p class="text-gray-300 mb-6">Please sign in to book tickets for this movie.</p>
                            <a href="{{ route('user.login') }}" class="bg-white hover:bg-gray-200 text-black font-bold px-8 py-3 rounded-lg transition shadow-lg inline-flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Sign In Now
                            </a>
                        </div>
                        @endauth

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-layouts.app>    