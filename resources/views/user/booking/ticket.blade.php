<x-layouts.app title="Tiket Anda">

    <div class="bg-black min-h-screen flex items-center justify-center py-12 px-4">

        <div class="w-full max-w-md">

            {{-- Ticket Card --}}
            <div class="relative">

                {{-- Success Animation Circle --}}
                <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-green-600 rounded-full flex items-center justify-center shadow-2xl shadow-green-500/50 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                {{-- Main Ticket --}}
                <div class="bg-gradient-to-br from-gray-900 to-black border-2 border-gray-800 rounded-2xl overflow-hidden shadow-2xl mt-16">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 text-center">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Booking Confirmed!</h2>
                        <p class="text-red-100 text-sm">Your ticket has been successfully created</p>
                    </div>

                    {{-- Dotted Line Separator --}}
                    <div class="relative h-8 bg-black">
                        <div class="absolute top-1/2 left-0 right-0 border-t-2 border-dashed border-gray-800 transform -translate-y-1/2"></div>
                        <div class="absolute top-1/2 -left-4 w-8 h-8 bg-black rounded-full border-2 border-gray-800 transform -translate-y-1/2"></div>
                        <div class="absolute top-1/2 -right-4 w-8 h-8 bg-black rounded-full border-2 border-gray-800 transform -translate-y-1/2"></div>
                    </div>

                    {{-- Ticket Details --}}
                    <div class="p-8 space-y-6">

                        {{-- Movie Title --}}
                        <div class="text-center pb-6 border-b border-gray-800">
                            <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Movie</p>
                            <h3 class="text-white text-xl sm:text-2xl font-bold">{{ $booking->movie->title }}</h3>
                        </div>

                        {{-- Ticket Code --}}
                        <div class="bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/30 rounded-xl p-6 text-center">
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-3 font-semibold">Your Ticket Code</p>
                            <div class="bg-black/50 rounded-lg p-4 mb-3">
                                <p class="text-yellow-400 text-2xl sm:text-3xl font-mono font-bold tracking-widest">
                                    {{ $booking->ticket_code }}
                                </p>
                            </div>
                            <p class="text-gray-500 text-xs">Show this code at the entrance</p>
                        </div>

                        {{-- QR Code --}}
                        <div class="bg-white p-6 rounded-xl">
                            <div class="flex justify-center">
                                {!! QrCode::size(200)->generate($booking->ticket_code) !!}
                            </div>
                        </div>

                        {{-- Movie Details --}}
                        <div class="space-y-3 pt-4 border-t border-gray-800">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Show Date
                                </span>
                                <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->movie->show_time)->format('d M Y') }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Show Time
                                </span>
                                <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->movie->show_time)->format('H:i') }} WIB</span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Booked By
                                </span>
                                <span class="text-white font-semibold">{{ $booking->user->name }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Status
                                </span>
                                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-600/50 rounded-full text-xs font-bold uppercase">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-6 space-y-3">
                            <a href="{{ route('booking.history') }}"
                                class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-bold py-3.5 rounded-lg transition shadow-lg hover:shadow-red-500/50">
                                View My Tickets
                            </a>

                            <a href="{{ route('movies.index') }}"
                                class="block w-full bg-gray-800 hover:bg-gray-700 text-white text-center font-semibold py-3.5 rounded-lg transition border border-gray-700">
                                Browse More Movies
                            </a>
                        </div>

                        {{-- Info Notice --}}
                        <div class="bg-blue-600/10 border border-blue-600/30 rounded-lg p-4 mt-6">
                            <div class="flex gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-blue-300 text-sm font-semibold mb-1">Important Notice</p>
                                    <p class="text-blue-200 text-xs leading-relaxed">Please arrive 15 minutes before showtime. Present this QR code or ticket code at the entrance.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.app>