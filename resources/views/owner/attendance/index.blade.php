<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header Section with OVO Gradient -->
        <div class="bg-gradient-to-r from-indigo-900 via-purple-800 to-violet-900 pb-24 pt-12 px-4 sm:px-6 lg:px-8 shadow-xl">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center text-white">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight flex items-center gap-2">
                            <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Absensi & Izin Staff
                        </h2>
                        <p class="text-purple-200 mt-1 ml-10">Monitor kehadiran dan kelola pengajuan izin karyawan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1: Total Pegawai -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pegawai</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $stats['employees'] }} <span class="text-xs font-normal text-gray-400">Orang</span></h3>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Card 2: Hadir Hari Ini -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Hadir Hari Ini</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $stats['present'] }} <span class="text-xs font-normal text-gray-400">Orang</span></h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Card 3: Terlambat -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Terlambat</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $stats['late'] }} <span class="text-xs font-normal text-gray-400">Orang</span></h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Card 4: Pengajuan Pending -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu ACC</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $stats['pending'] }} <span class="text-xs font-normal text-gray-400">Pengajuan</span></h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600 animate-pulse">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Session Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-md flex items-center justify-between animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-md flex items-center justify-between animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-yellow-500 hover:text-yellow-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-10">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Riwayat Kehadiran</h3>
                    <!-- Filter/Search could go here -->
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Pegawai</th>
                                <th class="px-6 py-4 text-left">Tanggal & Waktu</th>
                                <th class="px-6 py-4 text-left">Status Kehadiran</th>
                                <th class="px-6 py-4 text-left">Bukti / Catatan</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($attendances as $attendance)
                            <tr class="hover:bg-purple-50/30 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                                            {{ substr($attendance->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-bold text-gray-900">{{ $attendance->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $attendance->user->role ?? 'Staff' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $attendance->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 flex gap-2 mt-1">
                                        @if($attendance->clock_in)
                                            <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[10px] font-bold">IN: {{ $attendance->clock_in->format('H:i') }}</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-[10px] font-bold">IN: -</span>
                                        @endif

                                        @if($attendance->clock_out)
                                            <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-bold">OUT: {{ $attendance->clock_out->format('H:i') }}</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-[10px] font-bold">OUT: -</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->status == 'present')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                            ✅ Hadir
                                        </span>
                                    @elseif($attendance->status == 'late')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            ⏰ Terlambat
                                        </span>
                                    @elseif(in_array($attendance->status, ['sick', 'permit']))
                                        @if(is_null($attendance->is_approved))
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200 animate-pulse">
                                                ⏳ MENUNGGU
                                            </span>
                                            <div class="text-[10px] text-gray-400 mt-1 ml-2 font-medium uppercase tracking-wide">
                                                {{ $attendance->status == 'sick' ? 'Sakit' : 'Izin' }}
                                            </div>
                                        @elseif($attendance->is_approved)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-teal-100 text-teal-800 border border-teal-200">
                                                ✅ ACC ({{ ucfirst($attendance->status) }})
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                ⛔ DENIAL ({{ ucfirst($attendance->status) }})
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-600">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 italic max-w-xs truncate">
                                        "{{ $attendance->note ?? '-' }}"
                                    </div>
                                    @if($attendance->attachment)
                                        <a href="{{ asset('storage/' . $attendance->attachment) }}" target="_blank" class="inline-flex items-center mt-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs rounded-lg transition duration-200 border border-gray-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            Lihat Bukti
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <!-- Detail Button -->
                                        <button onclick='showDetail(@json($attendance), @json($attendance->user), @json(asset("storage/")))' class="p-2 bg-gray-100 rounded-lg text-gray-500 hover:text-purple-600 hover:bg-purple-50 transition" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        @if(in_array($attendance->status, ['sick', 'permit']) && is_null($attendance->is_approved))
                                            <form action="{{ route('owner.attendance.approve', $attendance) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg shadow-md transition transform hover:scale-110" title="Setujui Pengajuan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('owner.attendance.reject', $attendance) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg shadow-md transition transform hover:scale-110" title="Tolak Pengajuan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 bg-gray-50/30">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="text-lg font-medium text-gray-500">Belum ada data absensi.</p>
                                        <p class="text-sm text-gray-400 mt-1">Data kehadiran staff akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($attendances->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    {{ $attendances->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>

    <!-- Script for Detail Modal using SweetAlert2 (Cleaner than custom modal for simple details) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showDetail(data, user, assetUrl) {
            // Format Times
            const date = new Date(data.created_at).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            const clockIn = data.clock_in ? new Date(data.clock_in).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) : '-';
            const clockOut = data.clock_out ? new Date(data.clock_out).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) : '-';
            
            // Status Logic
            let statusHtml = '';
            if(data.status === 'present') statusHtml = '<span class="text-green-600 font-bold">Hadir</span>';
            else if(data.status === 'late') statusHtml = '<span class="text-yellow-600 font-bold">Terlambat</span>';
            else statusHtml = `<span class="text-blue-600 font-bold capitalize">${data.status}</span>`;

            // Attachment Logic
            let attachmentHtml = '';
            if(data.attachment) {
                attachmentHtml = `
                    <div class="mt-4 border-t pt-4">
                        <p class="text-sm font-bold text-gray-500 mb-2">Bukti Lampiran:</p>
                        <img src="${assetUrl}/${data.attachment}" class="w-full rounded-lg border border-gray-200 max-h-48 object-cover">
                        <a href="${assetUrl}/${data.attachment}" target="_blank" class="block mt-2 text-sm text-purple-600 font-bold hover:underline">Lihat Gambar Asli</a>
                    </div>
                `;
            }

            Swal.fire({
                title: `<div class="text-xl font-bold text-[#251A4A]">${user.name}</div>`,
                html: `
                    <div class="text-left text-sm space-y-3">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Tanggal</span>
                            <span class="font-bold text-gray-800">${date}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Status</span>
                            ${statusHtml}
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Jam Masuk</span>
                            <span class="font-mono font-bold text-gray-800">${clockIn}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Jam Pulang</span>
                            <span class="font-mono font-bold text-gray-800">${clockOut}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-gray-500 block mb-1">Catatan:</span>
                            <p class="bg-gray-50 p-3 rounded-lg text-gray-700 italic border border-gray-100">"${data.note || 'Tidak ada catatan'}"</p>
                        </div>
                        ${attachmentHtml}
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl p-6'
                }
            });
        }
    </script>
</x-app-layout>