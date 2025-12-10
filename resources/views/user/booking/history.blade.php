<x-layouts.app title="History Booking">

    <div class="bg-black min-h-screen text-white pb-12">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="pt-8 pb-6 border-b border-gray-800 mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold mb-6">My Tickets</h1>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('booking.history') }}" class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-lg p-4 sm:p-5">
                    <div class="flex flex-col lg:flex-row gap-4">

                        {{-- Search Input --}}
                        <div class="flex-1">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by code or title..."
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 placeholder-gray-500 transition">
                            </div>
                        </div>

                        {{-- Filter Select --}}
                        <div class="lg:w-64">
                            <select name="filter"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 cursor-pointer transition appearance-none">
                                <option value="">Latest First</option>
                                <option value="oldest" {{ request('filter') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="status_paid" {{ request('filter') == 'status_paid' ? 'selected' : '' }}>Status: Paid</option>
                                <option value="status_used" {{ request('filter') == 'status_used' ? 'selected' : '' }}>Status: Used</option>
                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 lg:flex-none bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition shadow-lg hover:shadow-red-500/50 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="hidden sm:inline">Search</span>
                            </button>

                            @if(request('search') || request('filter'))
                            <a href="{{ route('booking.history') }}" class="flex-1 lg:flex-none bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-semibold px-6 py-3 rounded-lg transition text-center">
                                Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- Bookings List --}}
            <div class="space-y-4">

                @forelse ($bookings as $booking)
                <div class="bg-gray-900/50 backdrop-blur-sm rounded-lg border border-gray-800 hover:border-gray-700 transition-all duration-300 overflow-hidden group">
                    <div class="p-5 sm:p-6 flex flex-col lg:flex-row gap-6">

                        {{-- Movie Info --}}
                        <div class="flex gap-4 flex-1">
                            {{-- Poster --}}
                            <div class="w-20 sm:w-24 h-28 sm:h-36 bg-gray-800 rounded-lg overflow-hidden flex-shrink-0 shadow-lg">
                                @if($booking->movie->poster)
                                <img src="{{ asset('storage/' . $booking->movie->poster) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                    alt="{{ $booking->movie->title }}">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg sm:text-xl text-white mb-2 truncate group-hover:text-red-500 transition">
                                    {{ $booking->movie->title }}
                                </h3>

                                <div class="space-y-1.5">
                                    <p class="text-gray-400 text-sm flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($booking->movie->show_time)->format('d M Y, H:i') }} WIB</span>
                                    </p>

                                    <p class="text-gray-500 text-xs flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Booked: {{ $booking->created_at->format('d M Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Ticket Info & Actions --}}
                        <div class="flex flex-col justify-between items-start lg:items-end gap-4 lg:min-w-[240px]">

                            {{-- Ticket Code --}}
                            <div class="bg-black/50 rounded-lg px-4 py-3 border border-gray-800 w-full lg:w-auto">
                                <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Ticket Code</span>
                                <span class="font-mono text-base sm:text-lg font-bold text-yellow-400 tracking-wider">
                                    {{ $booking->ticket_code }}
                                </span>
                            </div>

                            {{-- Status & Action --}}
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 w-full lg:w-auto">
                                <span class="px-4 py-2 text-xs font-bold rounded-lg uppercase tracking-wider text-center
                                    {{ $booking->status === 'paid' ? 'bg-green-600/20 text-green-400 border border-green-600/50' : 'bg-gray-800 text-gray-400 border border-gray-700' }}">
                                    {{ $booking->status }}
                                </span>

                                <a href="{{ route('booking.ticket', $booking->id) }}"
                                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition shadow-lg hover:shadow-red-500/50 text-center flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    View QR
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-gray-900/30 rounded-lg border border-gray-800 border-dashed">
                    <div class="text-gray-700 text-6xl mb-4">🎟️</div>
                    <h3 class="text-xl font-bold text-gray-300 mb-2">No Booking History</h3>
                    <p class="text-gray-500 mb-6">You haven't booked any tickets yet</p>
                    <a href="{{ route('movies.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-3 rounded-lg transition shadow-lg hover:shadow-red-500/50">
                        Browse Movies
                    </a>
                </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{-- $bookings->links() --}}
            </div>

        </div>
    </div>

</x-layouts.app>