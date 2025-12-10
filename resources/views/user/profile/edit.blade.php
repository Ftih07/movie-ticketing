<x-layouts.app title="Edit Profile">

    <div class="min-h-screen bg-black py-12 px-4">

        <div class="max-w-3xl mx-auto">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Account Settings</h1>
                <p class="text-gray-400">Manage your profile information and preferences</p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-600/10 border border-green-600/50 text-green-400 p-4 rounded-lg mb-6 flex items-start gap-3 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-semibold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- Profile Card --}}
            <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Profile Image Section --}}
                    <div class="bg-gradient-to-r from-red-600/20 to-red-600/10 border-b border-gray-800 p-8">
                        <div class="flex flex-col sm:flex-row items-center gap-6">

                            {{-- Current Image --}}
                            <div class="relative group">
                                @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                    alt="Profile"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-800 shadow-xl">
                                @else
                                <div class="w-32 h-32 rounded-full bg-gray-800 border-4 border-gray-700 flex items-center justify-center shadow-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                @endif

                                {{-- Edit Badge --}}
                                <div class="absolute bottom-0 right-0 bg-red-600 rounded-full p-2 shadow-lg border-4 border-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Upload Info --}}
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-xl font-bold text-white mb-2">Profile Picture</h3>
                                <p class="text-gray-400 text-sm mb-4">Upload a new photo to personalize your account</p>

                                <label class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-lg cursor-pointer transition border border-gray-700 hover:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span class="font-semibold">Choose Image</span>
                                    <input type="file" name="profile_image" class="hidden" accept="image/*" id="profileImageInput">
                                </label>

                                <p class="text-gray-500 text-xs mt-2">JPG, PNG or GIF (max. 2MB)</p>

                                @error('profile_image')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror

                                {{-- Preview Selected File --}}
                                <p class="text-gray-400 text-sm mt-2" id="fileName"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Form Fields --}}
                    <div class="p-8 space-y-6">

                        {{-- Name Field --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">
                                Full Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition"
                                    placeholder="Enter your full name">
                            </div>
                            @error('name')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email Field (Read Only) --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" value="{{ $user->email }}" disabled
                                    class="w-full bg-gray-900/50 border border-gray-800 text-gray-500 rounded-lg pl-12 pr-4 py-3.5 cursor-not-allowed"
                                    placeholder="Email address">
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Email cannot be changed</p>
                        </div>

                        {{-- Divider --}}
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-800"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-gray-900 text-gray-500">Change Password (Optional)</span>
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">
                                New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password"
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition"
                                    placeholder="Leave blank to keep current password">
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Must be at least 8 characters</p>
                            @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-2">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation"
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-12 pr-4 py-3.5 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition"
                                    placeholder="Confirm your new password">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-lg transition shadow-lg hover:shadow-red-500/50 transform hover:scale-[1.02] active:scale-[0.98]">
                                Save Changes
                            </button>
                            <a href="{{ route('movies.index') }}" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white text-center font-semibold py-3.5 rounded-lg transition border border-gray-700 hover:border-gray-600">
                                Cancel
                            </a>
                        </div>

                    </div>

                </form>

            </div>

            {{-- Account Info Card --}}
            <div class="mt-8 bg-gray-900/30 backdrop-blur-sm border border-gray-800 rounded-lg p-6">
                <h3 class="text-lg font-bold text-white mb-4">Account Information</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-800">
                        <span class="text-gray-400">Member Since</span>
                        <span class="text-white font-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Account Status</span>
                        <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-600/50 rounded-full text-xs font-bold uppercase">
                            Active
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- File Preview Script --}}
    <script>
        document.getElementById('profileImageInput').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const fileDisplay = document.getElementById('fileName');
            if (fileName) {
                fileDisplay.textContent = `Selected: ${fileName}`;
                fileDisplay.classList.add('text-green-400');
            }
        });
    </script>

</x-layouts.app>