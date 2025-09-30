@props(['disabled' => false, 'toggle' => true, 'bind' => null])

@php
    $isPassword = $attributes->get('type') === 'password';
@endphp

@if ($isPassword)
    @php
        $bindVar = $bind ? trim($bind) : 'show';
        $hasExternal = $bind !== null;
    @endphp
    <div @if(!$hasExternal) x-data="{ show: false }" @endif class="relative">
        <input x-bind:type="{{ $bindVar }} ? 'text' : 'password'"
               @disabled($disabled)
               {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10'])->except('type') }}>

        @if ($toggle)
        <button type="button"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                x-on:click="{{ $bindVar }} = !{{ $bindVar }}"
                aria-label="Toggle password visibility">
            <svg x-show="!({{ $bindVar }})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <svg x-show="{{ $bindVar }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.86 21.86 0 0 1-4.87 6.82M1 1l22 22"/>
            </svg>
        </button>
        @endif
    </div>
@else
    <input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
@endif
