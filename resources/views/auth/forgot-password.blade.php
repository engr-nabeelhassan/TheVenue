<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Forgot password</h2>
        <p class="text-sm text-gray-500">Enter your email to receive a reset link</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('reset_link'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">
            Reset link generated:
            <a class="underline font-medium" href="{{ session('reset_link') }}">{{ session('reset_link') }}</a>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send reset link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
