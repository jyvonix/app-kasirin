<x-app-layout>
    <x-slot name="header">Data Produk</x-slot>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#251A4A] tracking-tight">Katalog Produk</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola stok dan harga barang dagangan Anda.</p>
        </div>
        <a href="{{ route('products.create') }}" class="group relative inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white transition-all duration-200 bg-[#4C3494] font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4C3494] hover:bg-[#3C2A78] shadow-lg shadow-[#4C3494]/30 hover:shadow-[#4C3494]/50 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Produk
        </a>
    </div>

    <!-- Search & Filter (Live AJAX) -->
    <div class="mb-8">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg class="h-6 w-6 text-gray-400 group-focus-within:text-[#4C3494] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="searchInput" 
                class="block w-full pl-14 pr-4 py-5 bg-white border border-gray-100 rounded-3xl text-gray-900 text-lg placeholder-gray-400 focus:outline-none focus:border-[#4C3494]/20 focus:ring-4 focus:ring-[#4C3494]/10 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] transition-all duration-300 font-medium"
                placeholder="Cari produk (Ketik nama atau scan barcode)..." autofocus>
            
            <!-- Loading Indicator -->
            <div id="searchLoading" class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none opacity-0 transition-opacity duration-300">
                <svg class="animate-spin h-5 w-5 text-[#4C3494]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Product Grid Container -->
    <div id="product-grid-container" class="transition-opacity duration-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="product-grid">
            @include('products.partials.product-list', ['products' => $products])
        </div>

        <div class="mt-8" id="pagination-links">
            {{ $products->links() }}
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const gridContainer = document.getElementById('product-grid-container');
        const searchLoading = document.getElementById('searchLoading');
        let typingTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            searchLoading.classList.remove('opacity-0');
            
            typingTimer = setTimeout(() => {
                fetchProducts(this.value);
            }, 300); // Debounce 300ms
        });

        async function fetchProducts(query) {
            try {
                const response = await fetch(`{{ route('products.index') }}?search=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if(response.ok) {
                    const html = await response.text();
                    
                    // Replace content (Expects the partial to contain the grid items AND pagination if handled there, 
                    // but usually controller only returns items. If controller returns only items, we need to handle pagination manually or hide it.)
                    // Based on controller logic: if($request->ajax()) return view('products.partials.product-list')
                    
                    // So we update the grid. 
                    // Note: Ideally the partial should be ONLY the items. Pagination might be tricky with simple replace.
                    // For now, let's update the grid DIV.
                    
                    document.getElementById('product-grid').innerHTML = html;
                    
                    // Hide pagination if searching (since simple partial replace might not include new pagination links)
                    // Or ideally, the partial should include pagination links too.
                    const pagination = document.getElementById('pagination-links');
                    if(query.length > 0) {
                        pagination.style.display = 'none'; // Simple fix for now
                    } else {
                        // Refresh full page to restore pagination or handle complex logic
                        // For "responsiveness", hiding it is acceptable for search results.
                    }
                }
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                searchLoading.classList.add('opacity-0');
            }
        }
    </script>
</x-app-layout>