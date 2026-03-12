<x-app-layout>
    <x-slot name="header">Pengaturan Toko</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Konfigurasi Sistem</h2>
            
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama Toko -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Toko</label>
                        <input type="text" name="shop_name" value="{{ $settings['shop_name'] ?? '' }}" 
                            class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="Contoh: Kasirin Mart">
                    </div>

                    <!-- Pajak -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pajak PPN (%)</label>
                        <div class="relative">
                            <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] ?? '0' }}" 
                                class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-8"
                                placeholder="11">
                            <span class="absolute right-3 top-2.5 text-gray-400 font-bold">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Nilai ini akan otomatis ditambahkan di struk.</p>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Toko</label>
                        <textarea name="shop_address" rows="3" 
                            class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ $settings['shop_address'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
