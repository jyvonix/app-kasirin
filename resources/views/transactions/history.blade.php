<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="py-12 font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards (Optional Flavor) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                        <p class="text-2xl font-black text-gray-800 mt-1">{{ $transactions->count() }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-800">Daftar Transaksi Terbaru</h3>
                        <!-- Search Box -->
                        <div class="relative">
                            <input type="text" id="searchInvoice" placeholder="Cari invoice..." class="pl-10 pr-4 py-2 border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 transition-shadow duration-200">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-4 pl-4">Invoice</th>
                                    <th class="pb-4">Waktu</th>
                                    <th class="pb-4">Kasir</th>
                                    <th class="pb-4">Total</th>
                                    <th class="pb-4">Metode</th>
                                    <th class="pb-4">Status</th>
                                    <th class="pb-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm" id="transactionTableBody">
                                @forelse($transactions as $trx)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                    <td class="py-4 pl-4 font-mono font-bold text-indigo-600">
                                        {{ $trx->invoice_code }}
                                    </td>
                                    <td class="py-4 text-gray-600">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">{{ $trx->created_at->format('d M Y') }}</span>
                                            <span class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">
                                                {{ substr($trx->user ? $trx->user->name : '?', 0, 1) }}
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ $trx->user ? $trx->user->name : 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 font-bold text-gray-900">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4">
                                        @if($trx->payment_type == 'cash')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                                💵 Tunai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                📱 QRIS
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        @if($trx->payment_status == 'paid')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                Sukses
                                            </span>
                                        @elseif($trx->payment_status == 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center flex items-center justify-center gap-1">
                                        <button onclick="showDetail({{ $trx->id }})" class="text-gray-400 hover:text-indigo-600 transition-transform transform hover:scale-110 active:scale-95 p-2 rounded-full hover:bg-indigo-50" title="Lihat Detail & Struk">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @if(auth()->user()->isAdmin())
                                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" id="delete-form-{{ $trx->id }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $trx->id }})" class="text-gray-400 hover:text-red-600 transition-transform transform hover:scale-110 active:scale-95 p-2 rounded-full hover:bg-red-50" title="Hapus Transaksi">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                            <p>Belum ada riwayat transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeDetail()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-4xl flex flex-col md:flex-row">
                    
                    <!-- LEFT SIDE: DATA DETAIL -->
                    <div class="w-full md:w-3/5 p-8 bg-white relative">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Detail Transaksi</h3>
                                <p class="text-sm text-gray-500 mt-1 font-mono font-bold text-indigo-600" id="m_invoice">INV-Loading...</p>
                            </div>
                            <span id="m_status" class="px-4 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 shadow-sm">Loading...</span>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Tanggal</p>
                                <p id="m_date" class="font-bold text-gray-800 text-sm">-</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Kasir</p>
                                <p id="m_cashier" class="font-bold text-gray-800 text-sm">-</p>
                            </div>
                        </div>

                        <div class="border-t border-dashed border-gray-200 pt-6">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Item Pembelian
                            </h4>
                            <div class="overflow-y-auto max-h-60 pr-2 space-y-2 custom-scrollbar" id="m_items_container">
                                <!-- Items injected here -->
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                            <button id="repayBtn" onclick="payNow()" class="hidden bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg flex items-center gap-2 transition transform hover:-translate-y-0.5">
                                <span>Bayar Sekarang</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </button>
                            <button onclick="closeDetail()" class="text-gray-500 font-bold hover:text-gray-800 px-6 py-2.5 hover:bg-gray-50 rounded-xl transition">Tutup</button>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: STRUK PREVIEW (Visual Receipt) -->
                    <div class="w-full md:w-2/5 bg-gray-100 p-8 border-l border-gray-200 flex flex-col items-center justify-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-indigo-200 rounded-full blur-3xl opacity-50"></div>

                        <div class="bg-white p-6 w-full shadow-lg transform rotate-1 relative z-10" style="font-family: 'Courier New', monospace;">
                            <!-- Holes Top -->
                            <div class="absolute -top-2 left-0 w-full h-4 bg-gray-100 flex justify-between px-2">
                                <div class="w-4 h-4 rounded-full bg-gray-100"></div>
                            </div>

                            <div class="text-center mb-4 border-b-2 border-dashed border-gray-300 pb-4">
                                <h4 class="font-bold text-lg uppercase tracking-widest">KASIRIN</h4>
                                <p class="text-xs text-gray-500">Jl. Merdeka No. 45</p>
                                <p class="text-xs text-gray-500" id="s_date">--/--/----</p>
                                <p class="text-xs font-bold mt-1" id="s_invoice">INV-000</p>
                            </div>

                            <div class="space-y-2 text-xs mb-4 border-b-2 border-dashed border-gray-300 pb-4" id="s_items">
                                <!-- Receipt Items -->
                            </div>

                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between"><span>Subtotal</span><span id="s_subtotal">0</span></div>
                                <div class="flex justify-between text-red-500"><span>Diskon</span><span id="s_discount">0</span></div>
                                <div class="flex justify-between"><span>PPN</span><span id="s_tax">0</span></div>
                                <div class="flex justify-between font-bold text-sm mt-2 pt-2 border-t border-gray-300">
                                    <span>TOTAL</span><span id="s_total">0</span>
                                </div>
                                <div class="flex justify-between mt-2"><span>Tunai</span><span id="s_cash">0</span></div>
                                <div class="flex justify-between"><span>Kembalian</span><span id="s_change">0</span></div>
                            </div>

                            <div class="mt-6 text-center">
                                <p class="text-[10px] text-gray-400">Terima Kasih!</p>
                                <div class="mt-4">
                                    <a id="printBtn" href="#" target="_blank" class="block w-full bg-gray-800 text-white py-2 text-xs font-bold hover:bg-black transition">CETAK STRUK</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentSnapToken = null;
        let currentTrxId = null;

        function showDetail(id) {
            // Show Modal & Loader
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            
            // Reset Button State
            document.getElementById('repayBtn').classList.add('hidden');
            
            // Fetch Data
            fetch(`/riwayat-transaksi/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    currentTrxId = id;
                    currentSnapToken = data.snap_token;

                    // Populate Main Data
                    document.getElementById('m_invoice').innerText = data.invoice_code;
                    document.getElementById('m_date').innerText = data.date;
                    document.getElementById('m_cashier').innerText = data.cashier;
                    
                    // Status Badge
                    const statusEl = document.getElementById('m_status');
                    statusEl.innerText = data.payment_status === 'paid' ? 'LUNAS' : data.payment_status.toUpperCase();
                    statusEl.className = data.payment_status === 'paid' 
                        ? 'px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200'
                        : 'px-4 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200';

                    // Logic Tombol Bayar (Jika Pending & Non-Tunai)
                    if (data.payment_status === 'pending' && data.payment_type !== 'cash' && data.snap_token) {
                        document.getElementById('repayBtn').classList.remove('hidden');
                    } else {
                        document.getElementById('repayBtn').classList.add('hidden');
                    }

                    // Populate Items (Left Side)
                    const itemsContainer = document.getElementById('m_items_container');
                    itemsContainer.innerHTML = '';
                    data.items.forEach(item => {
                        itemsContainer.innerHTML += `
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">${item.name}</p>
                                    <p class="text-xs text-gray-500 font-mono mt-0.5">${item.qty} x ${formatRupiah(item.price)}</p>
                                </div>
                                <p class="font-bold text-gray-700 text-sm font-mono">${formatRupiah(item.subtotal)}</p>
                            </div>
                        `;
                    });

                    // Populate Struk Preview (Right Side)
                    document.getElementById('s_date').innerText = data.date;
                    document.getElementById('s_invoice').innerText = data.invoice_code;
                    
                    const sItems = document.getElementById('s_items');
                    sItems.innerHTML = '';
                    data.items.forEach(item => {
                        sItems.innerHTML += `
                            <div class="flex justify-between mb-1">
                                <span>${item.name.substring(0, 15)}</span>
                            </div>
                            <div class="flex justify-between mb-1 text-gray-600">
                                <span>${item.qty} x ${formatRupiah(item.price)}</span>
                                <span>${formatRupiah(item.subtotal)}</span>
                            </div>
                        `;
                    });

                    document.getElementById('s_subtotal').innerText = formatRupiah(data.subtotal);
                    document.getElementById('s_discount').innerText = '-' + formatRupiah(data.discount);
                    document.getElementById('s_tax').innerText = formatRupiah(data.tax);
                    document.getElementById('s_total').innerText = 'Rp ' + formatRupiah(data.total);
                    document.getElementById('s_cash').innerText = formatRupiah(data.cash);
                    document.getElementById('s_change').innerText = formatRupiah(data.change);

                    // Print Button Link
                    document.getElementById('printBtn').href = data.print_url;
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengambil data detail transaksi!',
                    });
                    closeDetail();
                });
        }

        function payNow() {
            if (!currentSnapToken) return;

            window.snap.pay(currentSnapToken, {
                onSuccess: function(result){
                    fetch(`/transactions/${currentTrxId}/update-status`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ status: 'paid' })
                    }).then(() => {
                        Swal.fire('Berhasil', 'Pembayaran diterima!', 'success').then(() => {
                            window.location.reload();
                        });
                    });
                },
                onPending: function(result){
                    Swal.fire('Pending', 'Menunggu pembayaran...', 'info');
                },
                onError: function(result){
                    Swal.fire('Gagal', 'Pembayaran gagal!', 'error');
                }
            });
        }

        function closeDetail() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Data transaksi dan detailnya akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Real-time Search Logic
        document.getElementById('searchInvoice').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#transactionTableBody tr');

            rows.forEach(row => {
                // Mencari text di kolom pertama (Invoice)
                let invoiceCell = row.querySelector('td:first-child');
                
                if (invoiceCell) {
                    let invoiceText = invoiceCell.innerText.toLowerCase();
                    if (invoiceText.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
</x-app-layout>