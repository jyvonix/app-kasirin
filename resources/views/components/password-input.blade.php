@props(['disabled' => false, 'name' => 'password', 'id' => 'password', 'placeholder' => '••••••••', 'value' => ''])

<div x-data="{ show: false }" class="relative group">
    <input 
        :type="show ? 'text' : 'password'"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'w-full pr-12 py-3.5 bg-gray-50 border-transparent rounded-2xl text-gray-800 font-bold placeholder-gray-400 focus:bg-white focus:border-[#00D5C3] focus:ring-2 focus:ring-[#00D5C3]/20 transition-all shadow-inner']) !!}
        placeholder="{{ $placeholder }}"
    />
    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#4C3494] transition-colors focus:outline-none cursor-pointer z-30">
        <!-- Icon Mata Terbuka (Show) -->
        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        
        <!-- Icon Mata Dicoret (Hide) -->
        <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.949-5.344m2.22-1.892a9.408 9.408 0 012.373-.764C12 5 15.791 7.943 17.065 12a10.057 10.057 0 01-1.373 3.424M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
        </svg>
    </button>
</div>
