<div class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-[#3C2A78] to-[#251A4A] text-white transition-transform transform -translate-x-full md:translate-x-0 z-30 font-sans shadow-2xl flex flex-col" id="sidebar">
    <!-- Logo Area -->
    <div class="flex-shrink-0 flex items-center justify-center h-24 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-[#00D5C3] rounded-xl flex items-center justify-center text-white shadow-lg shadow-[#00D5C3]/40">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold tracking-wide">KASIRIN<span class="text-[#00D5C3]">.</span></h1>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Pro System</p>
            </div>
        </div>
    </div>

    <!-- User Info (Mini Profile) -->
    <div class="flex-shrink-0 p-6">
        <div class="bg-white/5 rounded-2xl p-4 border border-white/5 flex items-center space-x-3 backdrop-blur-sm">
            @if(Auth::user()->avatar)
                <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-white/10">
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#00D5C3] to-[#4C3494] flex items-center justify-center font-bold text-sm shadow-md ring-2 ring-white/10">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                <div class="flex items-center mt-0.5">
                    <div class="w-2 h-2 rounded-full bg-[#00D5C3] mr-1.5 animate-pulse"></div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (Flexible & Scrollable) -->
    <nav class="flex-1 px-4 pb-6 space-y-1.5 overflow-y-auto custom-scrollbar">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span>Dashboard</span>
        </a>

        @if(!Auth::user()->isOwner())
        <!-- Scan Absensi -->
        <a href="{{ route('scan.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('scan.index') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('scan.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h2v-4H6v4zM6 20v-4m2 0h2v4h-2zM6 20h2m2-4h2v4h-2v-4zM6 4h2v4H6V4zm2 0h2v4H8V4zm2 0h2v4h-2V4zm-4 6h2v4H6v-4zm2 0h2v4H8v-4zm2 0h2v4h-2v-4z"></path></svg>
            <span>Scan Absensi</span>
        </a>

        <!-- Izin / Sakit -->
        <a href="{{ route('attendance.create') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('attendance.create') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('attendance.create') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Izin / Sakit</span>
        </a>
        @endif

        @if(Auth::user()->isAdmin() || Auth::user()->isCashier())
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Transaksi</p>
            </div>

            <!-- Voucher -->
            <a href="{{ route('vouchers.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('vouchers.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('vouchers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                <span>Voucher & Promo</span>
            </a>
        @endif

        <!-- --- MENU ADMIN --- -->
        @if(Auth::user()->isAdmin())
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Manajemen</p>
            </div>
            
            <!-- Produk -->
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('products.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('products.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Data Produk</span>
            </a>

            <!-- Pegawai -->
            <a href="{{ route('employees.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('employees.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('employees.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Kelola Pegawai</span>
            </a>

            <!-- Shift -->
            <a href="{{ route('shifts.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('shifts.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('shifts.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Shift Kerja</span>
            </a>

            <!-- Settings (Pajak) -->
            <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('settings.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Pengaturan</span>
            </a>
        @endif

        <!-- --- MENU KASIR --- -->
        @if(Auth::user()->isCashier())
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Kasir</p>
            </div>

            <a href="{{ route('kasir.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('kasir.index') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg shadow-pink-500/30' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('kasir.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <span class="font-bold">Mesin Kasir</span>
            </a>
        @endif

        <!-- --- MENU OWNER --- -->
        @if(Auth::user()->isOwner())
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Pemilik</p>
            </div>
            
            <a href="{{ route('owner.reports.financial') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('owner.reports.financial') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('owner.reports.financial') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Laporan Keuangan</span>
            </a>

            <a href="{{ route('owner.reports.products') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('owner.reports.products') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('owner.reports.products') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Laporan Produk</span>
            </a>

            <a href="{{ route('owner.attendance.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('owner.attendance.*') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('owner.attendance.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Rekap Absensi</span>
            </a>
        @endif

        @if(Auth::user()->isOwner() || Auth::user()->isCashier())
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Riwayat</p>
            </div>
            
            <a href="{{ route('transactions.history') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('transactions.history') ? 'bg-[#00D5C3] text-white shadow-lg shadow-[#00D5C3]/30 font-bold' : 'text-indigo-100 hover:bg-white/10 hover:text-white hover:pl-6' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('transactions.history') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Riwayat Transaksi</span>
            </a>
        @endif
    </nav>

    <!-- Logout Area (Fixed to bottom, but sidebar is flex) -->
    <div class="flex-shrink-0 p-4 border-t border-white/5 bg-[#251A4A]">
        <form method="POST" action="{{ route('logout') }}" class="logout-confirm">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors group">
                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center mr-3 group-hover:bg-red-500 transition-colors">
                    <svg class="w-4 h-4 text-red-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="font-bold text-sm">Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</div>

<!-- Custom Scrollbar Style -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>