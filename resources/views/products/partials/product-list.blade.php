@forelse($products as $product)
<div class="group relative bg-white rounded-[2rem] overflow-hidden shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-15px_rgba(76,52,148,0.2)] transition-all duration-300 flex flex-col h-full hover:-translate-y-1">
    
    <!-- Image Area -->
    <div class="h-56 bg-gray-50 relative overflow-hidden group-hover:opacity-90 transition-opacity">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @else
            <div class="w-full h-full bg-gradient-to-br from-[#F3E8FF] to-[#E0F2FE] flex items-center justify-center">
                <span class="text-4xl font-bold text-[#4C3494]/20 select-none">{{ substr($product->name, 0, 1) }}</span>
            </div>
        @endif

        <!-- Floating Badges -->
        <div class="absolute top-4 left-4 flex gap-2">
            <span class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-[#4C3494] shadow-sm">
                {{ $product->category->name ?? 'N/A' }}
            </span>
        </div>
        
        <div class="absolute top-4 right-4">
            @if($product->stock <= 0)
                <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-[10px] font-bold uppercase shadow-lg">Habis</span>
            @elseif($product->stock < 10)
                <span class="bg-orange-500 text-white px-3 py-1.5 rounded-full text-[10px] font-bold uppercase shadow-lg">Sisa {{ $product->stock }}</span>
            @else
                <span class="bg-[#00D5C3] text-white px-3 py-1.5 rounded-full text-[10px] font-bold uppercase shadow-lg">{{ $product->stock }} Stok</span>
            @endif
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-6 flex-1 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-bold text-[#251A4A] leading-snug mb-1 group-hover:text-[#4C3494] transition-colors line-clamp-2">
                {{ $product->name }}
            </h3>
            <p class="text-xs text-gray-400 font-mono flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h2v-4H6v4zM6 20v-4m2 0h2v4h-2zM6 20h2m2-4h2v4h-2v-4zM6 4h2v4H6V4zm2 0h2v4H8V4zm2 0h2v4h-2V4zm-4 6h2v4H6v-4zm2 0h2v4H8v-4zm2 0h2v4h-2v-4z"></path></svg>
                {{ $product->barcode ?? 'NO-CODE' }}
            </p>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-50 flex items-end justify-between">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Harga Jual</p>
                <p class="text-xl font-black text-[#4C3494]">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
            
            <!-- Quick Actions (Always Visible on Desktop for speed, or hover on mobile) -->
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product) }}" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 hover:bg-[#4C3494] hover:text-white flex items-center justify-center transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-span-full py-24 text-center bg-white rounded-[2.5rem] border border-dashed border-gray-200">
    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-tr from-[#F3E8FF] to-[#E0F2FE] mb-6">
        <svg class="w-10 h-10 text-[#4C3494]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>
    <h3 class="text-2xl font-black text-[#251A4A] tracking-tight">Tidak Ditemukan</h3>
    <p class="text-gray-500 mt-2">Coba kata kunci lain atau barcode yang berbeda.</p>
</div>
@endforelse
