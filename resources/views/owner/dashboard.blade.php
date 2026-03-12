<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section with OVO-like Gradient -->
        <div class="bg-gradient-to-br from-indigo-900 via-purple-800 to-violet-900 pb-32 pt-12 px-4 sm:px-6 lg:px-8 shadow-xl relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-white tracking-tight">Halo, Owner! 👋</h2>
                        <p class="text-purple-200 mt-1 text-sm font-medium">Ringkasan performa bisnis Anda hari ini.</p>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-purple-200 text-sm">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                </div>

                <!-- Main Stats Cards Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1: Omzet Hari Ini (Primary Focus) -->
                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl p-6 text-white shadow-lg hover:bg-white/20 transition duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 bg-gradient-to-br from-emerald-400 to-green-600 rounded-lg shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-semibold bg-emerald-500/20 text-emerald-200 py-1 px-2 rounded-full">+Hari Ini</span>
                        </div>
                        <h3 class="text-3xl font-bold tracking-tight">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
                        <p class="text-purple-200 text-sm mt-1">Total Pendapatan</p>
                    </div>

                    <!-- Card 2: Omzet Bulan Ini -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-purple-100 hover:shadow-xl transition duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-400">Bulan Ini</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 group-hover:text-purple-700 transition">Rp {{ number_format($monthSales, 0, ',', '.') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">Akumulasi Omzet</p>
                    </div>

                    <!-- Card 3: Transaksi -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-purple-100 hover:shadow-xl transition duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 bg-orange-100 text-orange-600 rounded-lg group-hover:bg-orange-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-400">Hari Ini</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 group-hover:text-orange-600 transition">{{ $todayTransactions }} <span class="text-sm font-normal text-gray-500">Transaksi</span></h3>
                        <p class="text-gray-500 text-sm mt-1">Aktivitas Kasir</p>
                    </div>

                    <!-- Card 4: Status Izin & Sakit (Detailed) -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-purple-100 hover:shadow-xl transition duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status Izin</span>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center">
                                <p class="text-xl font-black text-amber-500">{{ $pendingLeaves }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Pending</p>
                            </div>
                            <div class="text-center border-x border-gray-100">
                                <p class="text-xl font-black text-emerald-500">{{ $approvedLeaves }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">ACC</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-black text-red-500">{{ $rejectedLeaves }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Ditolak</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('owner.attendance.index') }}" class="mt-4 flex items-center justify-center py-2 bg-gray-50 rounded-xl text-xs font-bold text-purple-600 hover:bg-purple-600 hover:text-white transition-all">
                            Kelola Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20 pb-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Chart & Products -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Chart Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            Tren Penjualan (7 Hari Terakhir)
                        </h3>
                        <div id="salesChart" class="w-full h-64"></div>
                    </div>

                    <!-- Top Products Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800">🔥 Produk Terlaris Bulan Ini</h3>
                            <a href="{{ route('owner.reports.products') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Lihat Semua &rarr;</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($topProducts as $index => $item)
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-gray-400 w-6">{{ $index + 1 }}</span>
                                <div class="flex-1 ml-4">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-semibold text-gray-700">{{ $item->product->name }}</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $item->total_qty }} terjual</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2.5 rounded-full" style="width: {{ ($item->total_qty / $topProducts->first()->total_qty) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada data penjualan bulan ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Recent Activity & Quick Actions -->
                <div class="space-y-8">
                    
                    <!-- Quick Actions Grid -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('owner.reports.financial') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition duration-200 border border-purple-100 group">
                                <div class="w-10 h-10 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-purple-900 text-center">Laporan Keuangan</span>
                            </a>
                            <a href="{{ route('owner.attendance.index') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition duration-200 border border-blue-100 group">
                                <div class="w-10 h-10 bg-blue-200 text-blue-700 rounded-full flex items-center justify-center mb-2 group-hover:bg-blue-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-blue-900 text-center">Absensi Staff</span>
                            </a>
                        </div>
                        
                        @if($lowStockProducts > 0)
                        <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100 flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <p class="text-sm font-bold text-red-800">Stok Menipis!</p>
                                <p class="text-xs text-red-600 mt-1">Ada {{ $lowStockProducts }} produk dengan stok di bawah 10.</p>
                                <a href="{{ route('owner.reports.products') }}" class="text-xs font-semibold text-red-700 underline mt-1 block">Cek Stok</a>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Recent Transactions Feed -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Transaksi Terkini</h3>
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @forelse($recentTransactions as $transaction)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">TRX #{{ $transaction->id }} <span class="font-medium text-gray-900">oleh {{ $transaction->user->name ?? 'Kasir' }}</span></p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <div class="font-bold text-gray-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                                                    <time datetime="{{ $transaction->created_at }}">{{ $transaction->created_at->diffForHumans() }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="text-gray-500 text-sm text-center">Belum ada transaksi hari ini.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Penjualan',
                    data: @json($chartData)
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2, colors: ['#7C3AED'] },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100],
                        colorStops: [
                            { offset: 0, color: '#8B5CF6', opacity: 0.6 },
                            { offset: 100, color: '#8B5CF6', opacity: 0.1 }
                        ]
                    }
                },
                xaxis: {
                    categories: @json($chartLabels),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#9CA3AF' } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#9CA3AF' },
                        formatter: function (value) {
                            return "Rp " + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value);
                        }
                    }
                },
                grid: {
                    borderColor: '#F3F4F6',
                    strokeDashArray: 4,
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        });
    </script>
</x-app-layout>