<x-app-layout>
    <x-slot name="header">Kelola Voucher</x-slot>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#251A4A] tracking-tight">Voucher & Promo</h1>
            <p class="text-gray-500 mt-1 text-sm">Buat dan kelola kode diskon untuk pelanggan setia.</p>
        </div>
        @if(!Auth::user()->isCashier())
        <a href="{{ route('vouchers.create') }}" class="group relative inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white transition-all duration-200 bg-[#4C3494] font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4C3494] hover:bg-[#3C2A78] shadow-lg shadow-[#4C3494]/30">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buat Voucher Baru
        </a>
        @endif
    </div>

    <!-- Voucher Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($vouchers as $voucher)
        <div class="relative bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            
            <!-- Ticket Header (Gradient) -->
            <div class="h-32 bg-gradient-to-r from-[#4C3494] to-[#7F30C9] p-6 relative overflow-hidden flex flex-col justify-between">
                <!-- Deco Circles -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#00D5C3] to-transparent opacity-50"></div>

                <div class="flex justify-between items-start z-10">
                    <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-white/10">
                        {{ $voucher->type == 'fixed' ? 'Potongan Harga' : 'Diskon Persen' }}
                    </span>
                    
                    <!-- Action Menu (Absolute Top Right) -->
                    @if(!Auth::user()->isCashier())
                    <div class="flex gap-2">
                        <a href="{{ route('vouchers.edit', $voucher) }}" class="p-2 bg-white/20 rounded-full hover:bg-white text-white hover:text-[#4C3494] transition backdrop-blur-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('vouchers.destroy', $voucher) }}" method="POST" class="delete-form inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500/20 rounded-full hover:bg-red-500 text-white transition backdrop-blur-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <h3 class="text-3xl font-black text-white tracking-tight z-10">
                    {{ $voucher->type == 'fixed' ? 'Rp ' . number_format($voucher->amount, 0, ',', '.') : $voucher->amount . '%' }}
                </h3>
            </div>

            <!-- Cutout Effect (Ticket Holes) -->
            <div class="relative h-4 bg-white -mt-2 z-20 flex justify-between items-center px-2">
                <div class="w-4 h-4 bg-[#F8FAFC] rounded-full -ml-4 shadow-inner"></div>
                <div class="flex-1 border-t-2 border-dashed border-gray-200 mx-2"></div>
                <div class="w-4 h-4 bg-[#F8FAFC] rounded-full -mr-4 shadow-inner"></div>
            </div>

            <!-- Voucher Content -->
            <div class="p-6 pt-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Kode Voucher</p>
                        <div class="inline-flex items-center px-4 py-2 bg-[#F3E8FF] text-[#4C3494] font-mono text-lg font-bold rounded-lg border border-[#D8BFD8] border-dashed">
                            {{ $voucher->code }}
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Penggunaan</p>
                        @if($voucher->quantity === null)
                            <p class="font-bold text-green-600 flex items-center justify-end gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Unlimited
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Terpakai: {{ $voucher->used_count }}x</p>
                        @else
                            @php
                                $percent = ($voucher->used_count / $voucher->quantity) * 100;
                                $color = $percent >= 100 ? 'bg-red-500' : ($percent > 75 ? 'bg-orange-500' : 'bg-green-500');
                            @endphp
                            <p class="font-bold text-gray-800">{{ $voucher->used_count }} <span class="text-gray-400 mx-1">/</span> {{ $voucher->quantity }}</p>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="{{ $color }} h-1.5 rounded-full transition-all duration-500" style="width: {{ min(100, $percent) }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-500 bg-gray-50 p-4 rounded-xl">
                    <div class="flex justify-between">
                        <span>Min. Belanja:</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($voucher->min_purchase_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Berlaku Hingga:</span>
                        <span class="font-bold text-red-500">{{ \Carbon\Carbon::parse($voucher->end_date)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-purple-50 mb-4">
                <svg class="w-10 h-10 text-[#4C3494]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Belum Ada Voucher</h3>
            <p class="mt-2 text-gray-500">Buat voucher pertama Anda untuk menarik pelanggan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $vouchers->links() }}
    </div>
</x-app-layout>
