<x-layouts.app title="Register">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-20">
        <h2 class="text-xl font-semibold mb-4">Register</h2>

        <form method="POST" action="{{ route('user.register') }}">
            @csrf

            <label class="block mb-2">Name</label>
            <input name="name" required class="w-full border rounded px-3 py-2 mb-3">

            <label class="block mb-2">Email</label>
            <input name="email" type="email" required class="w-full border rounded px-3 py-2 mb-3">

            <label class="block mb-2">Password</label>
            <input name="password" type="password" required class="w-full border rounded px-3 py-2 mb-3">

            <label class="block mb-2">Confirm Password</label>
            <input name="password_confirmation" type="password" required class="w-full border rounded px-3 py-2 mb-4">

            <button class="w-full bg-blue-600 text-white py-2 rounded">Register</button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('user.login') }}" class="text-blue-600 hover:underline font-medium">
                Login disini
            </a>
        </div>
    </div>
</x-layouts.app>