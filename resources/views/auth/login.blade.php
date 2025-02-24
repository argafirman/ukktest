<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md transform transition duration-500 hover:scale-105">
        <!-- Logo atau ikon tambahan -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logoKue3.png') }}" alt="Logo Ryan Bakery" class="">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address dengan ikon -->
            <div class="relative">
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <div class="flex items-center">
                    <span class="absolute pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4h16v16H4V4zm0 0l8 8m8-8l-8 8" />
                        </svg>
                    </span>
                    <x-text-input id="email"
                        class="block mt-1 w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password dengan ikon -->
            <div class="relative mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <div class="flex items-center">
                    <span class="absolute pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 17v1m0-8v4m-6 3h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2zm6-7V7a4 4 0 10-8 0v3h8z" />
                            </svg>
                    </span>
                    <x-text-input id="password"
                        class="block mt-1 w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="password" name="password" required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Tombol Login dengan animasi hover -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __('Belum Punya Akun?') }}
                </a>
                @endif

                <x-primary-button
                    class="ms-3 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded shadow transform transition duration-300 hover:scale-105">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    </div>
</x-guest-layout>