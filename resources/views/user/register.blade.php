<x-layouts.app title="Register">

    <div class="min-h-screen bg-black flex items-center justify-center px-4 py-12">

        {{-- Background Pattern --}}
        <div class="absolute inset-0 overflow-hidden opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <div class="relative w-full max-w-md">

            {{-- Register Card --}}
            <div class="bg-black/70 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-600/20 to-red-600/10 border-b border-gray-800 p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-full mb-4 shadow-lg shadow-red-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">Join MovieFlix</h2>
                    <p class="text-gray-400 text-sm">Create your account to start booking</p>
                </div>

                {{-- Form --}}
                <div class="p-8">

                    {{-- Error Messages --}}
                    @if ($errors->any())
                    <div class="bg-red-600/10 border border-red-600/50 text-red-400 p-4 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="font-semibold text-sm mb-1">Please fix the following errors:</p>
                                <ul class="text-xs space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('user.register') }}" class="space-y-5">
                        @csrf

                        {{-- Name Field --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="name" required value="{{ old('name') }}"
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition placeholder-gray-500"
                                    placeholder="Enter your full name">
                            </div>
                        </div>

                        {{-- Email Field --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition placeholder-gray-500"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        {{-- Password Field --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition placeholder-gray-500"
                                    placeholder="Create a password">
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Must be at least 8 characters</p>
                        </div>

                        {{-- Confirm Password Field --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition placeholder-gray-500"
                                    placeholder="Confirm your password">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-lg transition shadow-lg hover:shadow-red-500/50 transform hover:scale-[1.02] active:scale-[0.98]">
                            Create Account
                        </button>

                    </form>

                    {{-- BARU: Divider OR --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-black/50 text-gray-500 backdrop-blur-xl">Or continue with</span>
                        </div>
                    </div>

                    {{-- BARU: Google Button --}}
                    <a href="{{ route('user.login.google') }}"
                        class="flex items-center justify-center w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3.5 rounded-lg transition transform hover:scale-[1.02] active:scale-[0.98]">
                        {{-- Google Logo SVG --}}
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                        Sign up with Google
                    </a>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-black text-gray-500">Already have an account?</span>
                        </div>
                    </div>

                    {{-- Login Link --}}
                    <a href="{{ route('user.login') }}" class="block w-full bg-gray-900 hover:bg-gray-800 border border-gray-700 hover:border-gray-600 text-white text-center font-semibold py-3.5 rounded-lg transition">
                        Sign In Instead
                    </a>

                </div>
            </div>

            {{-- Footer Text --}}
            <p class="text-center text-gray-600 text-sm mt-8">
                By creating an account, you agree to our Terms of Service and Privacy Policy
            </p>

        </div>
    </div>

</x-layouts.app>