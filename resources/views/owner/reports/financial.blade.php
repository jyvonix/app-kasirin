<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header Section with OVO Gradient -->
        <div class="bg-gradient-to-r from-indigo-900 via-purple-800 to-violet-900 pb-24 pt-12 px-4 sm:px-6 lg:px-8 shadow-xl">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center text-white">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-3xl font-bold tracking-tight flex items-center gap-2">
                            <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Laporan Keuangan
                        </h2>
                        <p class="text-purple-200 mt-1 ml-10">Analisis pendapatan dan arus kas bisnis Anda.</p>
                    </div>
                    
                    <!-- Filter Form Overlay -->
                    <div class="flex flex-col md:flex-row gap-3">
                        <form method="GET" action="{{ route('owner.reports.financial') }}" class="flex flex-col sm:flex-row gap-3 bg-white/10 backdrop-blur-sm p-2 rounded-xl border border-white/20">
                            <div>
                                <input type="date" name="start_date" value="{{ $startDate }}" class="block w-full rounded-lg border-0 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-400 sm:text-sm" required>
                            </div>
                            <div class="text-white self-center hidden sm:block">-</div>
                            <div>
                                <input type="date" name="end_date" value="{{ $endDate }}" class="block w-full rounded-lg border-0 bg-white/20 text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-400 sm:text-sm" required>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-white text-purple-900 rounded-lg font-semibold text-sm hover:bg-gray-100 transition shadow-lg">
                                Filter
                            </button>
                        </form>

                        <!-- Export Buttons -->
                        <div class="flex gap-2 p-2 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                            <a href="{{ route('owner.reports.financial.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-lg font-bold text-sm hover:bg-emerald-600 transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Excel
                            </a>
                            <a href="{{ route('owner.reports.financial.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex items-center gap-2 px-4 py-2 bg-rose-500 text-white rounded-lg font-bold text-sm hover:bg-rose-600 transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
            
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Jumlah Transaksi</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $transactions->count() }} <span class="text-sm font-normal text-gray-400">Trx</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Average Value -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-emerald-100 rounded-full text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Rata-rata Transaksi</p>
                            @php
                                $avg = $transactions->count() > 0 ? $totalRevenue / $transactions->count() : 0;
                            @endphp
                            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($avg, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-10">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Rincian Transaksi</h3>
                    <span class="text-xs text-gray-500">Menampilkan {{ $transactions->count() }} data</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">ID / Waktu</th>
                                <th class="px-6 py-3 text-left">Kasir</th>
                                <th class="px-6 py-3 text-left">Item</th>
                                <th class="px-6 py-3 text-left">Metode</th>
                                <th class="px-6 py-3 text-right">Total</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($transactions as $t)
                            <tr class="hover:bg-purple-50/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-purple-700">#{{ $t->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ substr($t->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <span class="ml-2 text-gray-700 font-medium">{{ $t->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-600">{{ $t->details->count() }} Produk</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $t->payment_method == 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} font-medium">
                                        {{ ucfirst($t->payment_method ?? 'Cash') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-900">
                                    Rp {{ number_format($t->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button onclick="showDetail({{ $t->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    <p>Tidak ada data transaksi pada periode ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination if needed -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                     <!-- Add pagination links here if using paginate() in controller -->
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
        function showDetail(id) {
            // Show Modal & Loader
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            
            // Fetch Data
            fetch(`/riwayat-transaksi/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
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

        function closeDetail() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    </script>
</x-app-layout>