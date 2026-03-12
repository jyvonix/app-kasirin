<x-app-layout>
    <x-slot name="header">Buat Voucher Baru</x-slot>

    <div class="max-w-5xl mx-auto" x-data="{
        code: 'PROMO123',
        amount: 0,
        type: 'fixed',
        min: 0,
        quota: 100,
        date: '{{ date('Y-m-d') }}'
    }">
        <a href="{{ route('vouchers.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#4C3494] mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Form Input -->
            <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-black text-[#251A4A] mb-6">Detail Voucher</h2>
                
                <form action="{{ route('vouchers.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Code -->
                    <div>
                        <x-input-label for="code" :value="__('Kode Voucher')" />
                        <input id="code" type="text" name="code" x-model="code" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] uppercase font-mono font-bold" required placeholder="CONTOH: MERDEKA45">
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Tipe Potongan')" />
                            <select id="type" name="type" x-model="type" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494]">
                                <option value="fixed">Nominal (Rp)</option>
                                <option value="percentage">Persentase (%)</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div>
                            <x-input-label for="amount" :value="__('Besar Potongan')" />
                            <input id="amount" type="number" name="amount" x-model="amount" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494]" required>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Min Purchase -->
                        <div>
                            <x-input-label for="min_purchase_amount" :value="__('Min. Belanja (Rp)')" />
                            <input id="min_purchase_amount" type="number" name="min_purchase_amount" x-model="min" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494]" required>
                            <x-input-error :messages="$errors->get('min_purchase_amount')" class="mt-2" />
                        </div>

            <!-- Kuota -->
            <div x-data="{ unlimited: true }">
                <x-input-label for="quantity" value="Batas Pemakaian (Kuota)" />
                <div class="flex items-center gap-4 mt-1">
                    <div class="flex-1 relative">
                        <x-text-input id="quantity" class="block w-full pl-10" type="number" name="quantity" x-bind:disabled="unlimited" placeholder="Contoh: 100" min="1" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer bg-purple-50 px-4 py-2.5 rounded-lg border border-purple-100 hover:bg-purple-100 transition">
                        <input type="checkbox" class="rounded border-gray-300 text-[#4C3494] shadow-sm focus:ring-[#4C3494]" x-model="unlimited">
                        <span class="text-sm font-bold text-gray-700">Unlimited</span>
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-1" x-show="!unlimited">Voucher tidak bisa digunakan lagi setelah kuota habis.</p>
                <p class="text-xs text-purple-600 font-bold mt-1" x-show="unlimited">✨ Voucher bisa digunakan tanpa batas jumlah pemakaian.</p>
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
            </div>
                    </div>

                    <!-- Date -->
                    <div>
                        <x-input-label for="end_date" :value="__('Berlaku Sampai')" />
                        <input id="end_date" type="date" name="end_date" x-model="date" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494]" required>
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full px-8 py-4 bg-[#4C3494] text-white font-bold rounded-xl shadow-lg hover:bg-[#3C2A78] transition transform hover:-translate-y-1">
                            Simpan Voucher
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Live Preview -->
            <div class="lg:col-span-1">
                <h3 class="font-bold text-gray-500 uppercase tracking-widest text-xs mb-4">Live Preview</h3>
                
                <!-- Ticket Card Preview -->
                <div class="sticky top-24">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-gray-100 transform rotate-1 hover:rotate-0 transition duration-500">
                        <!-- Gradient Head -->
                        <div class="h-40 bg-gradient-to-br from-[#4C3494] to-[#7F30C9] p-6 relative flex flex-col justify-center items-center text-center text-white overflow-hidden">
                            <div class="absolute top-[-20%] left-[-20%] w-32 h-32 bg-[#00D5C3] rounded-full blur-2xl opacity-30"></div>
                            <div class="absolute bottom-[-20%] right-[-20%] w-32 h-32 bg-[#F3E8FF] rounded-full blur-2xl opacity-20"></div>
                            
                            <p class="relative z-10 text-xs font-bold uppercase tracking-widest opacity-80 mb-2">Nilai Voucher</p>
                            <h2 class="relative z-10 text-4xl font-black tracking-tighter" x-text="type == 'fixed' ? 'Rp ' + parseInt(amount).toLocaleString('id-ID') : amount + '%'"></h2>
                            <span class="relative z-10 mt-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold border border-white/10">Valid Until: <span x-text="date"></span></span>
                        </div>

                        <!-- Rip Effect -->
                        <div class="relative h-6 bg-[#F8FAFC] -mt-3 z-10 flex justify-between items-center px-4">
                            <div class="w-6 h-6 bg-[#F8FAFC] rounded-full -ml-7 border-r border-gray-200"></div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-300 mx-2"></div>
                            <div class="w-6 h-6 bg-[#F8FAFC] rounded-full -mr-7 border-l border-gray-200"></div>
                        </div>

                        <!-- Body -->
                        <div class="p-6 bg-[#F8FAFC]">
                            <div class="bg-white p-4 rounded-xl border border-gray-200 text-center mb-4">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Kode Promo</p>
                                <p class="text-2xl font-mono font-bold text-[#4C3494] tracking-wider" x-text="code.toUpperCase()"></p>
                            </div>

                            <ul class="space-y-3 text-sm text-gray-500">
                                <li class="flex justify-between">
                                    <span>Min. Belanja</span>
                                    <span class="font-bold text-gray-800" x-text="'Rp ' + parseInt(min).toLocaleString('id-ID')"></span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Sisa Kuota</span>
                                    <span class="font-bold text-[#00D5C3]" x-text="quota"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <p class="text-center text-xs text-gray-400 mt-6">Preview tampilan voucher di aplikasi kasir.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>