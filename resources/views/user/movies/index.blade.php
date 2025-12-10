<x-layouts.app title="MOVIEFLIX">

    <div class="bg-black min-h-screen text-white pb-12">

        {{-- Hero Section --}}
        <div class="relative h-[40vh] sm:h-[50vh] mb-8 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent z-10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/50 z-10"></div>

            @if($movies->isNotEmpty())
            <img src="{{ asset('storage/' . $movies->first()->poster) }}"
                class="absolute inset-0 w-full h-full object-cover opacity-40"
                alt="Featured">
            @endif

            <div class="relative z-20 h-full flex items-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div class="max-w-2xl">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-4 leading-tight">
                        Unlimited movies, <br>
                        <span class="text-red-600">starting now.</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-300 mb-6">
                        Watch anywhere. Book anytime.
                    </p>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <form method="GET" action="{{ route('movies.index') }}" class="bg-black/50 backdrop-blur-sm p-4 sm:p-6 rounded-lg border border-gray-800 shadow-2xl">

                <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-end">

                    {{-- Search Input --}}
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Search Movies</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search for movies..."
                                class="w-full bg-gray-900/80 text-white border border-gray-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 placeholder-gray-500 transition">
                        </div>
                    </div>

                    {{-- Sort Select --}}
                    <div class="lg:w-64">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Sort By</label>
                        <select name="sort" class="w-full bg-gray-900/80 text-white border border-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 cursor-pointer transition appearance-none">
                            <option value="">Default</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Show Date (Earliest)</option>
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Show Date (Latest)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 lg:flex-none bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 shadow-lg hover:shadow-red-500/50">
                            Apply
                        </button>

                        @if(request('search') || request('sort'))
                        <a href="{{ route('movies.index') }}" class="flex-1 lg:flex-none bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Movies Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6">Now Showing</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">

                @forelse ($movies as $movie)
                <a href="{{ route('movies.show', $movie->id) }}" class="group relative rounded-lg overflow-hidden hover-scale cursor-pointer">

                    {{-- Movie Poster --}}
                    <div class="relative aspect-[2/3] overflow-hidden rounded-lg bg-gray-900">
                        <img src="{{ asset('storage/' . $movie->poster) }}"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-110 group-hover:opacity-75"
                            alt="{{ $movie->title }}">

                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Price Badge --}}
                        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg z-10">
                            IDR {{ number_format($movie->price / 1000) }}K
                        </div>

                        {{-- Hover Info --}}
                        <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="font-bold text-sm sm:text-base mb-1 line-clamp-2">
                                {{ $movie->title }}
                            </h3>

                            <div class="flex items-center text-gray-300 text-xs mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($movie->show_time)->format('d M Y') }}
                            </div>

                            <button class="w-full bg-white text-black font-semibold py-1.5 sm:py-2 rounded text-xs sm:text-sm hover:bg-gray-200 transition">
                                Book Now
                            </button>
                        </div>
                    </div>

                    {{-- Title Below (Mobile) --}}
                    <div class="mt-2 sm:hidden">
                        <h3 class="font-semibold text-sm line-clamp-2 text-gray-200">
                            {{ $movie->title }}
                        </h3>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-20">
                    <div class="text-gray-700 text-7xl mb-6">🎬</div>
                    <h3 class="text-2xl font-bold text-gray-300 mb-2">No Movies Found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search or filters</p>
                    <a href="{{ route('movies.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                        View All Movies
                    </a>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</x-layouts.app>