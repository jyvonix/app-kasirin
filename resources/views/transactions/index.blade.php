<x-app-layout>
    <!-- Kita tidak menggunakan x-slot:header agar tidak ada jarak/gap putih di atas -->

    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <!-- POS CONTAINER (Posisi Presisi & Full View) -->
    <div class="fixed inset-0 top-20 md:left-72 flex bg-[#F8FAFC] overflow-hidden font-sans z-10">
        
        <!-- LEFT: CATALOG SECTION -->
        <div class="flex-1 flex flex-col min-w-0 bg-white md:rounded-tl-[2.5rem] shadow-xl overflow-hidden border-t border-l border-gray-100">
            
            <!-- Header Kasir (Presisi & Bersih) -->
            <div class="px-8 py-5 flex flex-col lg:flex-row justify-between items-center gap-4 bg-white border-b border-gray-100">
                <div>
                    <h1 class="text-xl font-black text-[#251A4A] tracking-tight flex items-center gap-2">
                        Terminal Kasir
                        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-green-50 rounded-full border border-green-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[9px] font-black text-green-600 uppercase tracking-widest">Active</span>
                        </div>
                    </h1>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Sistem Kasir Pro v1.0</p>
                </div>

                <!-- Search Input -->
                <div class="relative w-full lg:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#4C3494] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="searchProduct" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-transparent focus:bg-white focus:border-[#4C3494] focus:ring-4 focus:ring-[#4C3494]/5 rounded-xl text-sm font-semibold text-gray-800 placeholder-gray-400 transition-all shadow-inner" placeholder="Cari menu... (F1)">
                </div>
            </div>

            <!-- Categories -->
            <div class="px-8 py-3 bg-gray-50/50 border-b border-gray-100 overflow-x-auto custom-scrollbar-h flex gap-2 items-center" id="category-tabs">
                <button onclick="filterCategory('all')" class="category-btn active px-5 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all bg-gray-900 text-white" data-id="all">
                    Semua
                </button>
                @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category->id }}')" class="category-btn px-5 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all bg-white text-gray-500 border border-gray-200 hover:border-purple-400 hover:text-purple-600" data-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            <!-- Product Grid (Optimized Spacing) -->
            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-[#F8FAFC]" id="product-list-container">
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6" id="product-grid">
                    @forelse($products as $product)
                    <div class="product-card group relative bg-white rounded-[1.5rem] shadow-sm hover:shadow-xl hover:shadow-purple-200/50 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer border border-gray-100 overflow-hidden flex flex-col"
                         onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->image ? asset('storage/' . $product->image) : '' }}')"
                         data-name="{{ strtolower($product->name) }}"
                         data-price="{{ $product->price }}"
                         data-category="{{ $product->category_id }}">
                        
                        <!-- Image Section (Reduced Height) -->
                        <div class="relative w-full h-40 overflow-hidden bg-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                    <span class="text-4xl font-black text-gray-200 group-hover:text-purple-200 transition-colors">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            @endif
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-300"></div>

                            <!-- Floating Stock Badge -->
                            <div class="absolute top-3 right-3">
                                <div class="px-2 py-1 bg-white/95 backdrop-blur-md rounded-lg shadow-sm flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $product->stock > 5 ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                    <span class="text-[10px] font-bold text-gray-700">Stok {{ $product->stock }}</span>
                                </div>
                            </div>

                            <!-- Add Icon -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-90 group-hover:scale-100">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-purple-600 shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-4 flex flex-col flex-1 relative bg-white">
                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 text-base leading-tight mb-1 line-clamp-2 group-hover:text-purple-700 transition-colors">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Category -->
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-3">
                                {{ $product->category ? $product->category->name : 'Menu' }}
                            </p>

                            <!-- Price -->
                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-end">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Harga</span>
                                    <span class="text-lg font-black text-gray-900 font-mono">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-gray-300">
                        <p class="text-lg font-black italic">No Menu Found.</p>
                    </div>
                    @endforelse
                </div>
                
                <div id="empty-state" class="hidden flex-col items-center justify-center py-20 text-gray-400">
                    <p class="text-lg font-bold italic">Menu tidak ditemukan...</p>
                </div>
            </div>
        </div>

        <!-- RIGHT: CART PANEL (Modern, Clean & Spacious) -->
        <div class="w-[420px] hidden xl:flex flex-col bg-white border-l border-gray-100 relative shadow-[-10px_0_30px_rgba(0,0,0,0.02)]">
            
            <!-- Cart Header -->
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-black text-[#251A4A] tracking-tight">Pesanan</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.1em]">No. Ref: #{{ date('Hi') }}{{ rand(10,99) }}</p>
                </div>
                <button onclick="clearCart()" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>

            <!-- Cart Body (View Frame Spacious & Clean) -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-gray-50/20" id="cart-items">
                <!-- Empty State (Clean & Balanced View) -->
                <div class="flex flex-col items-center justify-center min-h-[400px] text-gray-300" id="empty-cart-msg">
                    <div class="w-24 h-24 bg-white rounded-[2.5rem] shadow-sm flex items-center justify-center mb-6 border border-gray-50">
                        <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-xs font-black uppercase tracking-[0.2em]">Keranjang Kosong</p>
                    <p class="text-[9px] font-bold text-gray-400 mt-2 uppercase tracking-widest">Pilih menu untuk memulai</p>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="p-10 bg-white border-t border-gray-100 shadow-[0_-20px_50px_rgba(0,0,0,0.03)]">
                
                <!-- Promo Code -->
                <div class="mb-8 group">
                    <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 focus-within:ring-2 focus-within:ring-purple-500/10 focus-within:border-purple-500 transition-all">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        <input type="text" id="voucherCode" placeholder="Punya kode promo?" class="bg-transparent border-none p-0 text-sm font-bold text-gray-700 w-full focus:ring-0 placeholder-gray-300 uppercase tracking-widest">
                        <button onclick="checkVoucher()" class="text-[10px] font-black text-purple-600 hover:text-purple-800 tracking-widest transition-colors">APPLY</button>
                    </div>
                    <p id="voucherMsg" class="text-[10px] mt-2 font-bold px-1 h-3 transition-all"></p>
                </div>

                <!-- Summary -->
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay" class="text-gray-700 font-mono">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold text-green-500 uppercase tracking-widest" id="discountRow" style="display:none;">
                        <span>Discount</span>
                        <span id="discountDisplay" class="font-mono">-Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <span>Pajak ({{ $taxRate }}%)</span>
                        <span id="taxDisplay" class="text-gray-700 font-mono">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                        <span class="text-base font-black text-gray-900 uppercase tracking-tighter">Total Bayar</span>
                        <span id="grandTotalDisplay" class="text-3xl font-black text-gray-900 font-mono tracking-tighter">Rp 0</span>
                    </div>
                </div>

                <!-- Main Action -->
                <button onclick="openPaymentModal()" id="payBtn" disabled 
                    class="w-full py-5 rounded-[1.5rem] bg-gradient-to-r from-gray-900 to-gray-800 text-white font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-gray-900/20 hover:shadow-gray-900/40 transform active:scale-95 transition-all disabled:opacity-20 disabled:grayscale disabled:shadow-none flex items-center justify-center gap-3">
                    Proses Transaksi
                </button>
            </div>
        </div>
    </div>

    <!-- PAYMENT MODAL (Minimalist Glass) -->
    <div id="paymentModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity" onclick="closePaymentModal()"></div>
        
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden transform transition-all border border-gray-100">
                    
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-900 tracking-tighter uppercase">Konfirmasi Bayar</h3>
                        <button onclick="closePaymentModal()" class="text-gray-300 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-10">
                        <div class="text-center mb-10">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">Total Tagihan</p>
                            <h2 class="text-5xl font-black text-gray-900 font-mono tracking-tighter" id="modalTotalDisplay">Rp 0</h2>
                        </div>

                        <!-- Tabs -->
                        <div class="flex p-1.5 bg-gray-100 rounded-2xl mb-10">
                            <button id="tab-cash" onclick="switchTab('cash')" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm bg-white text-gray-900">
                                💵 Cash
                            </button>
                            <button id="tab-midtrans" onclick="switchTab('midtrans')" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-gray-400 hover:text-gray-600">
                                💳 Digital
                            </button>
                        </div>

                        <!-- CASH -->
                        <div id="content-cash" class="space-y-8 animate-fade-in">
                            <div class="relative">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Uang Diterima (IDR)</p>
                                <div class="relative">
                                    <input type="number" id="cashInput" class="w-full px-0 py-4 bg-transparent border-b-4 border-gray-100 focus:border-purple-600 text-4xl font-black text-gray-900 placeholder-gray-200 transition-all outline-none" placeholder="0" oninput="calculateChange()">
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-3">
                                @foreach([20000, 50000, 100000] as $amount)
                                <button onclick="setCash({{ $amount }})" class="py-3 bg-gray-50 hover:bg-gray-900 hover:text-white text-[10px] font-black rounded-xl transition-all border border-gray-100">{{ number_format($amount/1000, 0) }}K</button>
                                @endforeach
                                <button onclick="setExactCash()" class="py-3 bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white text-[10px] font-black rounded-xl transition-all border border-purple-100">PAS</button>
                            </div>

                            <div class="p-6 bg-gray-900 rounded-3xl flex justify-between items-center text-white shadow-2xl shadow-gray-900/30">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Kembalian</span>
                                <span class="text-2xl font-black font-mono tracking-tighter" id="changeDisplay">Rp 0</span>
                            </div>
                        </div>

                        <!-- DIGITAL -->
                        <div id="content-midtrans" class="hidden text-center py-6 animate-fade-in">
                            <div class="w-24 h-24 bg-purple-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            <h4 class="font-black text-gray-900 text-lg uppercase tracking-tight">QRIS & Cashless</h4>
                            <p class="text-xs text-gray-400 mt-2 font-medium px-10">Integrasi otomatis dengan GoPay, OVO, ShopeePay, dan Bank Transfer.</p>
                        </div>
                    </div>

                    <div class="p-10 pt-0">
                        <button type="button" id="confirmPayBtn" onclick="processTransaction()" class="w-full py-5 rounded-2xl bg-gray-900 text-white font-black text-sm uppercase tracking-[0.3em] shadow-xl hover:bg-black transition-all transform active:scale-95 disabled:opacity-10">
                            Konfirmasi & Proses
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STYLES -->
    <style>
        /* Modern Scrollbars */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E2E8F0; border-radius: 20px; border: 2px solid white; }
        
        .custom-scrollbar-h::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar-h::-webkit-scrollbar-track { background: #F8FAFC; border-radius: 10px; }
        .custom-scrollbar-h::-webkit-scrollbar-thumb { background-color: #CBD5E1; border-radius: 10px; }
        .custom-scrollbar-h::-webkit-scrollbar-thumb:hover { background-color: #94A3B8; }

        .animate-fade-in { animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>

    <!-- LOGIC -->
    <script>
        const TAX_RATE_PERCENT = {{ $taxRate }};
        const TAX_RATE_DECIMAL = TAX_RATE_PERCENT / 100;
        
        let cart = [];
        let currentTotal = 0;
        let discount = 0;
        let activeVoucherCode = null;
        let selectedPaymentMethod = 'cash';
        let activeCategory = 'all';

        const cartContainer = document.getElementById('cart-items');
        const emptyCartMsg = document.getElementById('empty-cart-msg');
        const searchInput = document.getElementById('searchProduct');
        const payBtn = document.getElementById('payBtn');
        const confirmPayBtn = document.getElementById('confirmPayBtn');

        // Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F1') { e.preventDefault(); searchInput.focus(); }
            if (e.key === 'F2') { e.preventDefault(); if(!payBtn.disabled) openPaymentModal(); }
            if (e.key === 'Escape') { closePaymentModal(); }
        });

        // Search & Filter
        searchInput.addEventListener('input', filterProducts);

        function filterProducts() {
            const keyword = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            let found = false;

            products.forEach(card => {
                const name = card.getAttribute('data-name');
                const category = card.getAttribute('data-category');
                const matchesSearch = name.includes(keyword);
                const matchesCategory = activeCategory === 'all' || category == activeCategory;

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'flex';
                    found = true;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('empty-state').style.display = found ? 'none' : 'flex';
        }

        function filterCategory(categoryId) {
            activeCategory = categoryId;
            document.querySelectorAll('.category-btn').forEach(btn => {
                if(btn.dataset.id == categoryId) {
                    btn.classList.add('bg-gray-900', 'text-white', 'border-gray-900');
                    btn.classList.remove('bg-white', 'text-gray-500', 'border-gray-200');
                } else {
                    btn.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
                    btn.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
                }
            });
            filterProducts();
        }

        // Cart Logic
        function addToCart(id, name, price, maxStock, image = '') {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.qty < maxStock) {
                    existingItem.qty++;
                } else {
                    Toast.fire({ icon: 'warning', title: 'Stok Habis!' });
                    return;
                }
            } else {
                if(maxStock <= 0) {
                    Toast.fire({ icon: 'error', title: 'Stok Habis!' });
                    return;
                }
                cart.push({ id, name, price, qty: 1, max: maxStock, image: image });
            }
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            if(cart.length === 0) resetCartState();
            renderCart();
        }

        function updateQty(id, change) {
            const item = cart.find(item => item.id === id);
            if (!item) return;
            const newQty = item.qty + change;
            if (newQty > 0 && newQty <= item.max) {
                item.qty = newQty;
                renderCart();
            }
        }

        function resetCartState() {
            discount = 0;
            activeVoucherCode = null;
            document.getElementById('voucherCode').value = '';
            document.getElementById('voucherMsg').innerText = '';
        }

        function clearCart() {
            if(cart.length === 0) return;
            Swal.fire({
                title: 'Reset Keranjang?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    cart = [];
                    resetCartState();
                    renderCart();
                }
            });
        }

        function renderCart() {
            cartContainer.innerHTML = '';
            let subtotal = 0;

            if (cart.length === 0) {
                emptyCartMsg.style.display = 'flex';
                payBtn.disabled = true;
                updateTotals(0);
                return;
            }

            emptyCartMsg.style.display = 'none';
            payBtn.disabled = false;

            cart.forEach(item => {
                const totalItemPrice = item.price * item.qty;
                subtotal += totalItemPrice;
                const html = `
                    <div class="flex items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm animate-fade-in group hover:border-[#4C3494]/20 transition-all">
                        <!-- Modern View Frame: Product Thumbnail -->
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-50">
                            ${item.image ? `<img src="${item.image}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center bg-purple-50 text-purple-200 text-lg font-black">${item.name.charAt(0)}</div>`}
                        </div>

                        <!-- Product Detail Frame -->
                        <div class="flex-1 px-4 min-w-0">
                            <h4 class="font-bold text-[#251A4A] text-[13px] leading-tight mb-1 truncate">${item.name}</h4>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rp${formatRupiah(item.price)}</div>
                        </div>

                        <!-- Action Frame (Modern Controls) -->
                        <div class="flex flex-col items-end gap-2">
                            <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                                <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 flex items-center justify-center bg-white text-gray-900 rounded shadow-sm hover:bg-gray-900 hover:text-white transition-all text-xs font-black">-</button>
                                <span class="px-2 text-[11px] font-black min-w-[25px] text-center text-[#251A4A]">${item.qty}</span>
                                <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 flex items-center justify-center bg-white text-gray-900 rounded shadow-sm hover:bg-gray-900 hover:text-white transition-all text-xs font-black">+</button>
                            </div>
                            <div class="font-black text-[#251A4A] text-sm tracking-tight">Rp${formatRupiah(totalItemPrice)}</div>
                        </div>
                        
                        <!-- Minimalist Remove -->
                        <button onclick="removeFromCart(${item.id})" class="ml-3 p-1 text-gray-200 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                `;
                cartContainer.insertAdjacentHTML('beforeend', html);
            });
            updateTotals(subtotal);
        }

        function updateTotals(subtotal) {
            document.getElementById('subtotalDisplay').innerText = 'Rp' + formatRupiah(subtotal);
            let taxable = Math.max(0, subtotal - discount);
            
            if (discount > 0) {
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountDisplay').innerText = '-Rp' + formatRupiah(discount);
            } else { document.getElementById('discountRow').style.display = 'none'; }

            let tax = taxable * TAX_RATE_DECIMAL;
            document.getElementById('taxDisplay').innerText = 'Rp' + formatRupiah(tax);

            currentTotal = Math.round(taxable + tax);
            document.getElementById('grandTotalDisplay').innerText = 'Rp' + formatRupiah(currentTotal);
        }

        // Voucher
        async function checkVoucher() {
            const code = document.getElementById('voucherCode').value;
            if (!code) return;
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            
            try {
                const response = await fetch(`{{ route('transactions.check_voucher') }}?code=${code}&total=${subtotal}`);
                const data = await response.json();
                const msgEl = document.getElementById('voucherMsg');
                
                if (data.valid) {
                    discount = data.discount_amount;
                    activeVoucherCode = code;
                    msgEl.innerText = data.message;
                    msgEl.className = 'text-[10px] mt-2 font-bold h-3 text-green-600';
                    updateTotals(subtotal);
                    Toast.fire({ icon: 'success', title: 'Voucher Active!' });
                } else {
                    discount = 0;
                    activeVoucherCode = null;
                    msgEl.innerText = data.message;
                    msgEl.className = 'text-[10px] mt-2 font-bold h-3 text-red-500';
                    updateTotals(subtotal);
                }
            } catch (e) { console.error(e); }
        }

        // Modal Logic
        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('modalTotalDisplay').innerText = 'Rp' + formatRupiah(currentTotal);
            document.getElementById('cashInput').value = '';
            calculateChange();
            switchTab('cash');
            setTimeout(() => document.getElementById('cashInput').focus(), 100);
        }

        function closePaymentModal() { document.getElementById('paymentModal').classList.add('hidden'); }

        function switchTab(method) {
            selectedPaymentMethod = method;
            const cashTab = document.getElementById('tab-cash');
            const midtransTab = document.getElementById('tab-midtrans');
            
            if (method === 'cash') {
                cashTab.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                cashTab.classList.remove('text-gray-400');
                midtransTab.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                midtransTab.classList.add('text-gray-400');
                document.getElementById('content-cash').classList.remove('hidden');
                document.getElementById('content-midtrans').classList.add('hidden');
                calculateChange();
            } else {
                midtransTab.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                midtransTab.classList.remove('text-gray-400');
                cashTab.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                cashTab.classList.add('text-gray-400');
                document.getElementById('content-midtrans').classList.remove('hidden');
                document.getElementById('content-cash').classList.add('hidden');
                confirmPayBtn.disabled = false;
                confirmPayBtn.innerText = 'Lanjut Bayar Digital';
            }
        }

        function calculateChange() {
            if (selectedPaymentMethod !== 'cash') return;
            const input = parseFloat(document.getElementById('cashInput').value) || 0;
            const change = input - currentTotal;
            const changeDisplay = document.getElementById('changeDisplay');

            if (change >= 0) {
                changeDisplay.innerText = 'Rp' + formatRupiah(change);
                changeDisplay.classList.remove('text-red-400');
                confirmPayBtn.disabled = false;
                confirmPayBtn.innerText = 'Konfirmasi Bayar';
            } else {
                changeDisplay.innerText = 'Kurang Rp' + formatRupiah(Math.abs(change));
                changeDisplay.classList.add('text-red-400');
                confirmPayBtn.disabled = true;
                confirmPayBtn.innerText = 'Uang Kurang';
            }
        }

        function setCash(amount) { document.getElementById('cashInput').value = amount; calculateChange(); }
        function setExactCash() { document.getElementById('cashInput').value = currentTotal; calculateChange(); }

        // Process Transaction
        async function processTransaction() {
            const cashAmount = parseFloat(document.getElementById('cashInput').value) || 0;
            const payload = {
                cart: cart,
                payment_method: selectedPaymentMethod,
                cash_amount: selectedPaymentMethod === 'cash' ? cashAmount : 0,
                voucher_code: activeVoucherCode,
                _token: '{{ csrf_token() }}'
            };

            confirmPayBtn.disabled = true;
            confirmPayBtn.innerText = 'Sinking...';

            try {
                const response = await fetch('{{ route('transactions.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();

                if (!response.ok) throw new Error(data.message || 'Error');

                if (selectedPaymentMethod === 'cash') {
                    closePaymentModal();
                    Swal.fire({
                        title: 'Success!',
                        text: `Change: Rp${formatRupiah(data.transaction.change_amount)}`,
                        icon: 'success',
                        confirmButtonText: 'Print Receipt',
                        confirmButtonColor: '#111827',
                    }).then(() => {
                        window.open(`/transactions/${data.transaction.id}/print`, '_blank', 'width=400,height=600');
                        window.location.reload();
                    });
                } else if (selectedPaymentMethod === 'midtrans') {
                    closePaymentModal();
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            updateStatusServer(data.transaction.id, 'paid');
                            Swal.fire('Paid', 'Payment Received', 'success').then(() => window.location.reload());
                        },
                        onPending: function(result){ Swal.fire('Pending', 'Complete payment', 'info'); },
                        onError: function(result){ Swal.fire('Error', 'Payment failed', 'error'); confirmPayBtn.disabled = false; }
                    });
                }
            } catch (error) {
                Toast.fire({ icon: 'error', title: error.message });
                confirmPayBtn.disabled = false;
            }
        }

        async function updateStatusServer(trxId, status) {
            await fetch(`/transactions/${trxId}/update-status`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ status: status })
            });
        }

        function formatRupiah(number) { return new Intl.NumberFormat('id-ID').format(Math.round(number)); }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
</x-app-layout>