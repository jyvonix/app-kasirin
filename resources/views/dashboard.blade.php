<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <!-- Welcome Section (Premium Banner) -->
    <div class="relative bg-white rounded-[2rem] p-8 mb-8 shadow-sm border border-gray-100 overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-[#F3E8FF] to-transparent opacity-50"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-[#251A4A] tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-500 mt-2 text-lg">Siap mencetak rekor penjualan hari ini?</p>
            </div>
            
            @if(!Auth::user()->isOwner())
            <div class="flex gap-3">
                 <a href="{{ route('kasir.index') }}" class="group relative px-6 py-3 bg-[#4C3494] text-white rounded-2xl font-bold shadow-lg shadow-[#4C3494]/30 hover:shadow-[#4C3494]/50 transition-all transform hover:-translate-y-1">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Transaksi Baru
                    </span>
                 </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Omzet (Purple Gradient) -->
        <div class="relative bg-gradient-to-br from-[#4C3494] to-[#7F30C9] rounded-[2rem] p-6 text-white shadow-xl shadow-purple-500/20 overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-white/20 backdrop-blur-md rounded-2xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-lg text-white">+{{ rand(5,20) }}%</span>
                </div>
                <div class="mt-4">
                    <p class="text-purple-100 text-sm font-medium">Total Omzet Hari Ini</p>
                    <h3 class="text-3xl font-extrabold mt-1">Rp {{ number_format($todaysIncome ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 2: Transaksi (Cyan Gradient) -->
        <div class="relative bg-gradient-to-br from-[#00D5C3] to-[#00A3B5] rounded-[2rem] p-6 text-white shadow-xl shadow-cyan-500/20 overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-white/20 backdrop-blur-md rounded-2xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-cyan-50 text-sm font-medium">Transaksi Berhasil</p>
                    <h3 class="text-3xl font-extrabold mt-1">{{ $todaysCount ?? 0 }} <span class="text-lg font-normal opacity-80">Pesanan</span></h3>
                </div>
            </div>
        </div>
        
        <!-- Card 3: Status Absensi & Izin (Clean White) -->
        <div class="relative bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col justify-center">
             <div class="flex items-center gap-4">
                 <div class="w-12 h-12 rounded-full 
                    @if(!$todayAttendance) bg-gray-100 text-gray-400
                    @elseif($todayAttendance->status == 'sick' || $todayAttendance->status == 'permit')
                        @if(is_null($todayAttendance->is_approved)) bg-amber-100 text-amber-600
                        @elseif($todayAttendance->is_approved) bg-emerald-100 text-emerald-600
                        @else bg-red-100 text-red-600 @endif
                    @else bg-green-100 text-green-600 @endif 
                    flex items-center justify-center flex-shrink-0">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                 </div>
                 <div>
                     <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Status Absensi Hari Ini</p>
                     @if(!$todayAttendance)
                        <h4 class="text-lg font-bold text-gray-400">Belum Ada Data</h4>
                        <p class="text-xs text-gray-500">Silakan scan QR untuk masuk.</p>
                     @elseif($todayAttendance->status == 'sick' || $todayAttendance->status == 'permit')
                        <div class="flex flex-col">
                            <h4 class="text-lg font-bold {{ is_null($todayAttendance->is_approved) ? 'text-amber-600' : ($todayAttendance->is_approved ? 'text-emerald-600' : 'text-red-600') }}">
                                {{ $todayAttendance->status == 'sick' ? 'Sakit' : 'Izin' }} 
                                ({{ is_null($todayAttendance->is_approved) ? 'Pending' : ($todayAttendance->is_approved ? 'ACC' : 'Ditolak') }})
                            </h4>
                            <p class="text-xs text-gray-500 italic">"{{ Str::limit($todayAttendance->note, 30) }}"</p>
                        </div>
                     @elseif(!$todayAttendance->clock_out)
                        <h4 class="text-lg font-bold text-green-600">Sedang Bekerja</h4>
                        <p class="text-xs text-gray-500">Masuk jam {{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '-' }}</p>
                     @else
                        <h4 class="text-lg font-bold text-gray-800">Selesai Shift</h4>
                        <p class="text-xs text-gray-500">Pulang jam {{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '-' }}</p>
                     @endif
                 </div>
             </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Quick Menu (Left) -->
        <div class="lg:col-span-2">
            <h3 class="font-bold text-[#251A4A] text-lg mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                
                @if(Auth::user()->isAdmin())
                <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-md hover:border-[#4C3494]/30 transition group">
                    <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-[#4C3494] mb-3 group-hover:bg-[#4C3494] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Produk</span>
                </a>

                <a href="{{ route('employees.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-md hover:border-[#4C3494]/30 transition group">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Pegawai</span>
                </a>
                @endif

                <a href="{{ route('scan.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-md hover:border-[#4C3494]/30 transition group">
                    <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-3 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h2v-4H6v4zM6 20v-4m2 0h2v4h-2zM6 20h2m2-4h2v4h-2v-4zM6 4h2v4H6V4zm2 0h2v4H8V4zm2 0h2v4h-2V4zm-4 6h2v4H6v-4zm2 0h2v4H8v-4zm2 0h2v4h-2v-4z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Scan Absen</span>
                </a>

                @if(Auth::user()->isCashier() || Auth::user()->isAdmin())
                <a href="{{ route('transactions.history') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-md hover:border-[#4C3494]/30 transition group">
                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-3 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Laporan</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Stock Alert (Right) -->
        <div class="lg:col-span-1">
            <h3 class="font-bold text-[#251A4A] text-lg mb-4">Peringatan Stok</h3>
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 h-full min-h-[250px]">
                @if($lowStockProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockProducts->take(4) as $product)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-500 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ Str::limit($product->name, 15) }}</p>
                                    <p class="text-xs text-red-500 font-medium">Sisa: {{ $product->stock }}</p>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-[#4C3494] bg-[#4C3494]/10 px-3 py-1 rounded-full hover:bg-[#4C3494] hover:text-white transition">Restock</a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-40 text-center">
                        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-3">
                             <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Semua stok aman!</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    <!-- Modal Pengajuan Izin (Sama, hanya styling tombol) -->
    <x-modal name="leave-modal" :show="$errors->has('attachment') || $errors->has('note')" focusable>
        <form method="post" action="{{ route('attendance.leave') }}" enctype="multipart/form-data" class="p-8">
            @csrf
            <h2 class="text-xl font-bold text-[#251A4A] mb-6">Pengajuan Izin / Sakit</h2>
            
            <div class="mb-4">
                <x-input-label for="status" value="Jenis Izin" />
                <select id="status" name="status" class="mt-1 block w-full border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] rounded-xl shadow-sm py-3" required>
                    <option value="sick">Sakit</option>
                    <option value="permit">Izin</option>
                </select>
            </div>
            
            <div class="mb-4">
                <x-input-label for="note" value="Keterangan" />
                <textarea id="note" name="note" class="mt-1 block w-full border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] rounded-xl shadow-sm" rows="3" required placeholder="Jelaskan alasan izin/sakit..."></textarea>
                <x-input-error :messages="$errors->get('note')" class="mt-2" />
            </div>
            
            <div class="mb-8">
                <x-input-label for="attachment" value="Bukti (Surat Dokter/Lainnya)" />
                <input id="attachment" type="file" name="attachment" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#F3E8FF] file:text-[#4C3494] hover:file:bg-[#E9D5FF]" />
                <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 rounded-xl text-gray-600 font-bold hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#4C3494] text-white font-bold hover:bg-[#3C2A78] transition shadow-lg shadow-[#4C3494]/30">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
