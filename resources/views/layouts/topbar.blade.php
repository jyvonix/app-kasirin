<header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100 z-20 h-20 flex items-center justify-between px-6 sticky top-0">
    <!-- Mobile Hamburger -->
    <button @click="sidebarOpen = !sidebarOpen" class="text-[#4C3494] focus:outline-none md:hidden p-2 rounded-xl hover:bg-gray-100 transition">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Page Title / Breadcrumb -->
    <div>
        <h2 class="font-extrabold text-2xl text-[#251A4A] tracking-tight">
            {{ $title ?? 'Dashboard' }}
        </h2>
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center space-x-4">
        
        <!-- Clock (Optional Deco) -->
        <div class="hidden md:block text-right mr-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::now()->format('l, d F') }}</p>
        </div>

        <!-- Profile Dropdown Trigger -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                <div class="w-10 h-10 rounded-full bg-gray-100 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden transition group-hover:border-[#00D5C3]">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="font-bold text-[#4C3494]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </div>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl py-2 z-50 border border-gray-100" style="display: none;">
                
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>