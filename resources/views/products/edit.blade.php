<x-app-layout>
    <x-slot name="header">Edit Produk</x-slot>

    <div class="max-w-6xl mx-auto" x-data="{
        name: '{{ $product->name }}',
        price: {{ $product->price }},
        stock: {{ $product->stock }},
        category: '{{ $product->category_id }}',
        sku: '{{ $product->sku }}',
        imageUrl: '{{ $product->image ? asset('storage/' . $product->image) : null }}',
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imageUrl = URL.createObjectURL(file);
            }
        }
    }">
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#4C3494] mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Form Section -->
            <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-black text-[#251A4A]">Edit Produk</h2>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase">Mode Edit</span>
                </div>
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nama Produk -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <input id="name" type="text" name="name" x-model="name" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] font-bold" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori -->
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" x-model="category" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494]">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- SKU -->
                        <div>
                            <x-input-label for="sku" :value="__('Kode Barang (SKU)')" />
                            <input id="sku" type="text" name="sku" x-model="sku" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga -->
                        <div>
                            <x-input-label for="price" :value="__('Harga Jual (Rp)')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold">Rp</span>
                                </div>
                                <input id="price" type="number" name="price" x-model="price" class="block w-full pl-10 rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] font-bold text-lg" required>
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Stok -->
                        <div>
                            <x-input-label for="stock" :value="__('Stok Saat Ini')" />
                            <input id="stock" type="number" name="stock" x-model="stock" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4C3494] focus:ring-[#4C3494] font-bold" required>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <x-input-label for="image" :value="__('Ganti Foto (Opsional)')" />
                        
                        @if($product->image)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-20 w-20 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#4C3494] hover:text-[#3C2A78] focus-within:outline-none">
                                        <span>Upload file baru</span>
                                        <input id="image" name="image" type="file" class="sr-only" @change="fileChosen">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full px-8 py-4 bg-[#4C3494] text-white font-bold rounded-xl shadow-lg hover:bg-[#3C2A78] transition transform hover:-translate-y-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <h3 class="font-bold text-gray-500 uppercase tracking-widest text-xs mb-4">Live Preview</h3>
                
                <div class="sticky top-24">
                    <div class="group relative bg-white rounded-[2rem] overflow-hidden shadow-2xl border border-gray-100 flex flex-col h-full transform rotate-1 hover:rotate-0 transition duration-500">
                        <!-- Image Placeholder / Preview -->
                        <div class="h-48 bg-gray-50 relative flex items-center justify-center overflow-hidden">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!imageUrl">
                                <div class="w-full h-full bg-gradient-to-br from-[#F3E8FF] to-[#E0F2FE] flex items-center justify-center">
                                    <svg class="w-16 h-16 text-[#4C3494]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </template>
                            
                            <!-- Badges -->
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-[#4C3494] shadow-sm">
                                Preview
                            </span>
                            <div class="absolute top-4 right-4">
                                <span class="bg-[#00D5C3] text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase shadow-lg">Tersedia</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-[#251A4A] leading-tight mb-1" x-text="name || 'Nama Produk'"></h3>
                                <p class="text-xs text-gray-400 font-mono" x-text="sku || 'SKU-CODE'"></p>
                            </div>

                            <div class="mt-auto flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Harga Satuan</p>
                                    <p class="text-xl font-black text-[#4C3494]" x-text="'Rp ' + parseInt(price || 0).toLocaleString('id-ID')"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 mb-1">Stok</p>
                                    <p class="font-bold text-gray-800" x-text="stock || 0"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>