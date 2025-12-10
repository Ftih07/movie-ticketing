<x-layouts.app title="Login">

<div class="flex justify-center mt-20">
    <div class="w-full max-w-md bg-white p-8 shadow rounded">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" required
                class="w-full border rounded px-3 py-2 mb-4">

            <label class="block mb-2 font-semibold">Password</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2 mb-6">

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                Login
            </button>
        </form>
    </div>
</div>

</x-layouts.app>
