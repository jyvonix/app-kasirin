<x-app-layout>
    <x-slot name="header">Kelola Pegawai</x-slot>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Pegawai</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola akses, jabatan, dan shift kerja pegawai Anda.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="group relative inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white transition-all duration-200 bg-purple-600 font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 hover:bg-purple-700 shadow-lg shadow-purple-500/30 overflow-hidden">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Pegawai
        </a>
    </div>

    <!-- Search / Filter (Modern Real-time) -->
    <div class="mb-8 relative max-w-2xl mx-auto md:mx-0">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <input type="text" id="searchEmployee" class="block w-full pl-12 pr-4 py-4 border-none rounded-2xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500/50 shadow-lg shadow-purple-100/50 transition-all duration-300 ease-in-out" placeholder="Cari pegawai berdasarkan nama, email, atau role...">
    </div>

    <!-- Employee Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="employeeGrid">
        @foreach($employees as $employee)
        <div class="employee-card bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-purple-100 transition-all duration-300 transform hover:-translate-y-1 group relative overflow-hidden">
            
            <!-- Decorative Gradient Background Top (OVO Style) -->
            <div class="absolute top-0 left-0 right-0 h-28 bg-gradient-to-br from-purple-600 to-violet-500 opacity-10 group-hover:opacity-20 transition-opacity"></div>
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-400 rounded-full mix-blend-multiply filter blur-2xl opacity-10 animate-blob"></div>
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-violet-400 rounded-full mix-blend-multiply filter blur-2xl opacity-10 animate-blob animation-delay-2000"></div>

            <!-- Profile Header -->
            <div class="relative flex items-center mb-6 z-10 pt-2">
                @if($employee->avatar)
                    <div class="w-16 h-16 rounded-full shadow-lg shadow-purple-500/30 mr-4 transform group-hover:scale-105 transition-transform border-4 border-white overflow-hidden">
                        <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-purple-600 to-violet-500 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-purple-500/30 mr-4 transform group-hover:scale-105 transition-transform border-4 border-white">
                        {{ substr($employee->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 leading-tight truncate group-hover:text-purple-700 transition-colors search-name">{{ $employee->name }}</h3>
                    <p class="text-xs text-gray-500 font-medium mt-1 truncate search-email">{{ $employee->email }}</p>
                    <div class="flex gap-2 mt-2">
                        <button onclick="showQrCode('{{ $employee->name }}', '{{ $employee->qr_token }}')" class="text-xs bg-purple-50 hover:bg-purple-100 text-purple-700 px-3 py-1 rounded-full flex items-center transition w-fit font-semibold">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h2v-4H6v4zM6 20v-4m2 0h2v4h-2zM6 20h2m2-4h2v4h-2v-4zM6 4h2v4H6V4zm2 0h2v4H8V4zm2 0h2v4h-2V4zm-4 6h2v4H6v-4zm2 0h2v4H8v-4zm2 0h2v4h-2v-4z"></path></svg>
                            QR Code
                        </button>
                        <a href="{{ route('employees.print-card', $employee) }}" target="_blank" class="text-xs bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1 rounded-full flex items-center transition w-fit font-semibold border border-gray-200">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                            Print Card
                        </a>
                    </div>
                </div>
            </div>

            <!-- Role & Shift Badges -->
            <div class="flex flex-wrap gap-2 mb-6 relative z-10">
                <!-- Role Badge -->
                <span class="search-role inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                    @if($employee->role == 'admin') bg-purple-100 text-purple-700 border border-purple-200
                    @elseif($employee->role == 'owner') bg-amber-100 text-amber-800 border border-amber-200
                    @else bg-green-100 text-green-700 border border-green-200 @endif">
                    {{ $employee->role == 'owner' ? 'Owner' : ($employee->role == 'admin' ? 'Admin' : 'Kasir') }}
                </span>

                <!-- Shift Badge -->
                @if($employee->shift)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-gray-50 text-gray-600 border border-gray-200">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ \Carbon\Carbon::parse($employee->shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($employee->shift->end_time)->format('H:i') }}
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-gray-50 text-gray-400 border border-gray-200">
                    Non-Shift
                </span>
                @endif
            </div>

            <!-- Action Buttons (Bottom) -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-50 relative z-10">
                <a href="{{ route('employees.edit', $employee) }}" class="flex items-center text-sm font-bold text-gray-500 hover:text-purple-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </a>

                <button onclick="confirmDelete('{{ $employee->id }}', '{{ $employee->name }}')" class="flex items-center text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
                <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        @endforeach

        <!-- Empty State (Modern) -->
        <div id="emptyState" class="hidden col-span-full py-16 text-center bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-purple-50 mb-6">
                <svg class="w-10 h-10 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Tidak ditemukan</h3>
            <p class="mt-2 text-gray-500">Coba kata kunci pencarian yang lain.</p>
        </div>

        @if($employees->isEmpty())
        <div class="col-span-full py-16 text-center bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-purple-50 mb-6">
                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Belum ada pegawai</h3>
            <p class="mt-2 text-gray-500">Mulai dengan menambahkan pegawai baru ke sistem.</p>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $employees->links() }}
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // QR Code Modal
        function showQrCode(name, token) {
            Swal.fire({
                title: '<span class="text-xl font-bold text-gray-800">ID Pegawai: ' + name + '</span>',
                html: `
                    <div class="flex justify-center p-6 bg-gray-50 rounded-2xl mb-4">
                        <div id="qrcode" class="p-2 bg-white rounded-xl shadow-sm"></div>
                    </div>
                    <p class="text-sm text-gray-500">Scan QR ini di Kiosk Absensi untuk melakukan presensi.</p>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl border border-gray-100 shadow-2xl',
                    closeButton: 'focus:outline-none'
                },
                didOpen: () => {
                    new QRCode(document.getElementById("qrcode"), {
                        text: token,
                        width: 180,
                        height: 180,
                        colorDark : "#4c1d95", // Dark Purple for QR
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                }
            });
        }

        // Delete Confirmation
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Pegawai?',
                text: "Apakah Anda yakin ingin menghapus data pegawai " + name + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9333ea', // Purple-600
                cancelButtonColor: '#9ca3af', // Gray-400
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Real-time Search
        document.getElementById('searchEmployee').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.employee-card');
            let hasVisible = false;

            cards.forEach(card => {
                let name = card.querySelector('.search-name').textContent.toLowerCase();
                let email = card.querySelector('.search-email').textContent.toLowerCase();
                let role = card.querySelector('.search-role').textContent.toLowerCase();

                if (name.includes(filter) || email.includes(filter) || role.includes(filter)) {
                    card.classList.remove('hidden');
                    hasVisible = true;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show empty state if no results
            let emptyState = document.getElementById('emptyState');
            if (!hasVisible && filter !== '') {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>