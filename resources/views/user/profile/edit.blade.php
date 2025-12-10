<x-layouts.app title="Edit Profile">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-4 flex justify-center">
                @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border">
                @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    No Img
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label class="block mb-2 text-sm font-medium text-gray-700">Profile Image</label>
                <input type="file" name="profile_image" class="w-full border rounded px-3 py-2">
                @error('profile_image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <label class="block mb-2">Name</label>
            <input name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded px-3 py-2 mb-3">

            <label class="block mb-2">New Password (leave blank to keep)</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2 mb-3">

            <label class="block mb-2">Confirm New Password</label>
            <input name="password_confirmation" type="password" class="w-full border rounded px-3 py-2 mb-4">

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Save</button>
        </form>
    </div>
</x-layouts.app>