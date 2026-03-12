<x-app-layout>
    <x-slot name="header">Kelola Shift Kerja</x-slot>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Shift & Jadwal</h1>
            <p class="text-gray-500 mt-1 text-sm">Atur waktu kerja operasional untuk pegawai Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Tambah Shift (Sticky Sidebar) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl shadow-purple-100 border border-gray-100 overflow-hidden sticky top-24">
                <!-- Decorative Header -->
                <div class="bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-5">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Buat Shift Baru
                    </h3>
                    <p class="text-purple-100 text-xs mt-1 opacity-90">Tentukan jam masuk dan pulang.</p>
                </div>

                <form action="{{ route('shifts.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    <div class="space-y-5">
                        <!-- Nama Shift -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Shift</label>
                            <input type="text" name="name" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3" placeholder="Contoh: Shift Pagi" required>
                        </div>

                        <!-- Waktu -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Masuk</label>
                                <div class="relative">
                                    <input type="time" id="start_time" name="start_time" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3 px-3 text-center font-mono font-bold text-gray-800" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Pulang</label>
                                <div class="relative">
                                    <input type="time" id="end_time" name="end_time" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3 px-3 text-center font-mono font-bold text-gray-800" required>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Preview -->
                        <div id="duration-box" class="hidden p-3 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-wide">Total Durasi</span>
                            <span id="duration-text" class="text-sm font-extrabold text-purple-800">0 Jam</span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full group relative flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg shadow-purple-500/30 transition-all transform hover:-translate-y-0.5">
                            Simpan Shift
                            <svg class="ml-2 -mr-1 w-5 h-5 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Grid List Shift -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($shifts as $shift)
                @php
                    $start = \Carbon\Carbon::parse($shift->start_time);
                    $end = \Carbon\Carbon::parse($shift->end_time);
                    
                    // Simple logic for icon: Pagi/Siang = Sun, Sore/Malam = Moon
                    $hour = $start->hour;
                    $isDay = $hour >= 6 && $hour < 18;
                    
                    // Duration logic
                    if ($end->lessThan($start)) {
                        $end->addDay();
                    }
                    $diff = $start->diff($end);
                    $duration = $diff->format('%h Jam %i Menit');
                    if ($diff->i == 0) $duration = $diff->format('%h Jam');
                @endphp

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-purple-100 transition-all duration-300 transform hover:-translate-y-1 relative group overflow-hidden">
                    
                    <!-- Decorative Circle -->
                    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full {{ $isDay ? 'bg-orange-100' : 'bg-purple-100' }} opacity-50 group-hover:scale-150 transition-transform duration-500"></div>

                    <div class="flex justify-between items-start relative z-10">
                        <!-- Icon & Name -->
                        <div class="flex items-start">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner mr-4 {{ $isDay ? 'bg-gradient-to-br from-orange-400 to-yellow-400 text-white shadow-orange-200' : 'bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-purple-200' }}">
                                {{ $isDay ? '☀️' : '🌙' }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $shift->name }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 mt-2 rounded-full text-xs font-bold {{ $isDay ? 'bg-orange-50 text-orange-600' : 'bg-indigo-50 text-indigo-600' }}">
                                    {{ $duration }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Edit Button -->
                        <button onclick="openEditModal('{{ $shift->id }}', '{{ $shift->name }}', '{{ $shift->start_time }}', '{{ $shift->end_time }}')" class="text-gray-300 hover:text-purple-600 p-2 rounded-xl hover:bg-purple-50 transition-colors mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        
                        <!-- Delete Button -->
                        <button onclick="confirmDeleteShift('{{ $shift->id }}', '{{ $shift->name }}')" class="text-gray-300 hover:text-red-500 p-2 rounded-xl hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        <form id="delete-shift-{{ $shift->id }}" action="{{ route('shifts.destroy', $shift) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>

                    <!-- Time Display -->
                    <div class="mt-6 flex items-center justify-between bg-gray-50 rounded-2xl p-4 border border-gray-100 group-hover:border-purple-100 transition-colors">
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Masuk</p>
                            <p class="text-lg font-black text-gray-800 font-mono">{{ $start->format('H:i') }}</p>
                        </div>
                        <div class="flex-1 border-b-2 border-dashed border-gray-200 mx-4 relative top-1"></div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Pulang</p>
                            <p class="text-lg font-black text-gray-800 font-mono">{{ $end->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Empty State -->
                @if($shifts->isEmpty())
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada shift</h3>
                    <p class="mt-1 text-sm text-gray-500">Buat shift baru menggunakan form di samping kiri.</p>
                </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $shifts->links() }}
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white" id="modal-title">Edit Shift</h3>
                    <button onclick="closeEditModal()" class="text-white hover:text-purple-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="edit-form" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Shift</label>
                            <input type="text" id="edit_name" name="name" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Masuk</label>
                                <input type="time" id="edit_start_time" name="start_time" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3 px-3 text-center font-mono font-bold text-gray-800" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Pulang</label>
                                <input type="time" id="edit_end_time" name="end_time" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-gray-50 focus:bg-white transition-colors py-3 px-3 text-center font-mono font-bold text-gray-800" required>
                            </div>
                        </div>

                        <div id="edit-duration-box" class="p-3 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-wide">Total Durasi</span>
                            <span id="edit-duration-text" class="text-sm font-extrabold text-purple-800">0 Jam</span>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="button" onclick="closeEditModal()" class="mr-3 px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-3 bg-purple-600 text-white text-sm font-bold rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-500/30 transition-all">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Real-time Duration Calculation (Create Form)
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const durationBox = document.getElementById('duration-box');
        const durationText = document.getElementById('duration-text');

        // Real-time Duration Calculation (Edit Form)
        const editStartTimeInput = document.getElementById('edit_start_time');
        const editEndTimeInput = document.getElementById('edit_end_time');
        const editDurationBox = document.getElementById('edit-duration-box');
        const editDurationText = document.getElementById('edit-duration-text');

        function calculateDuration(startEl, endEl, textEl, boxEl) {
            const start = startEl.value;
            const end = endEl.value;

            if (start && end) {
                let startDate = new Date(`2000-01-01T${start}`);
                let endDate = new Date(`2000-01-01T${end}`);

                // Handle overnight shifts
                if (endDate < startDate) {
                    endDate.setDate(endDate.getDate() + 1);
                }

                const diff = endDate - startDate;
                const hours = Math.floor(diff / 1000 / 60 / 60);
                const minutes = Math.floor((diff / 1000 / 60) % 60);

                let text = `${hours} Jam`;
                if (minutes > 0) text += ` ${minutes} Menit`;

                textEl.textContent = text;
                boxEl.classList.remove('hidden');
            } else {
                boxEl.classList.add('hidden');
            }
        }

        // Attach listeners for Create Form
        startTimeInput.addEventListener('input', () => calculateDuration(startTimeInput, endTimeInput, durationText, durationBox));
        endTimeInput.addEventListener('input', () => calculateDuration(startTimeInput, endTimeInput, durationText, durationBox));

        // Attach listeners for Edit Form
        editStartTimeInput.addEventListener('input', () => calculateDuration(editStartTimeInput, editEndTimeInput, editDurationText, editDurationBox));
        editEndTimeInput.addEventListener('input', () => calculateDuration(editStartTimeInput, editEndTimeInput, editDurationText, editDurationBox));

        // Modal Functions
        function openEditModal(id, name, start, end) {
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit_name').value = name;
            
            // Format time to HH:mm for input type="time"
            document.getElementById('edit_start_time').value = start.substring(0, 5);
            document.getElementById('edit_end_time').value = end.substring(0, 5);
            
            // Update Action URL
            document.getElementById('edit-form').action = `/shifts/${id}`;
            
            // Trigger calculation
            calculateDuration(editStartTimeInput, editEndTimeInput, editDurationText, editDurationBox);
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Delete Confirmation
        function confirmDeleteShift(id, name) {
            Swal.fire({
                title: 'Hapus Shift?',
                text: `Pegawai di shift "${name}" akan kehilangan jadwal mereka. Lanjutkan?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9333ea', // Purple
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-shift-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>