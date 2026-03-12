<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header Section with OVO Gradient -->
        <div class="bg-gradient-to-r from-indigo-900 via-purple-800 to-violet-900 pb-24 pt-12 px-4 sm:px-6 lg:px-8 shadow-xl">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center text-white">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight flex items-center gap-2">
                            <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Inventaris & Stok Produk
                        </h2>
                        <p class="text-purple-200 mt-1 ml-10">Pantau ketersediaan stok barang secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
            
            <!-- Inventory Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $products->count() }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-xl text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Stok Menipis (< 10)</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-1">
                            {{ $products->filter(fn($p) => $p->stock < 10 && $p->stock > 0)->count() }}
                        </h3>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-xl text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Stok Habis</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-1">
                            {{ $products->where('stock', 0)->count() }}
                        </h3>
                    </div>
                    <div class="p-3 bg-red-100 rounded-xl text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-10">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Daftar Stok Produk</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Prioritas: Stok terendah ditampilkan lebih dulu.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Produk</th>
                                <th class="px-6 py-4 text-left">Kategori</th>
                                <th class="px-6 py-4 text-right">Harga Satuan</th>
                                <th class="px-6 py-4 text-left w-1/4">Status Stok</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($products as $product)
                            <tr class="hover:bg-purple-50/30 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-bold border border-gray-200 overflow-hidden">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-purple-700 transition">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 font-mono">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2.5 mr-3 overflow-hidden">
                                            @php
                                                // Asumsi max stok aman = 100 untuk bar visual
                                                $percentage = min(100, ($product->stock / 50) * 100);
                                                $colorClass = $product->stock < 10 ? 'bg-red-500' : ($product->stock < 30 ? 'bg-yellow-500' : 'bg-green-500');
                                            @endphp
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-bold {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-700' }} w-8 text-right">{{ $product->stock }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($product->stock == 0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 border border-red-200 shadow-sm">
                                            HABIS
                                        </span>
                                    @elseif($product->stock < 10)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm animate-pulse">
                                            MENIPIS
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                            AMAN
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <p class="font-medium text-gray-500">Belum ada data produk.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>