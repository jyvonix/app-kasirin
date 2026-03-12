<x-app-layout>
    <x-slot name="header">Edit Pegawai</x-slot>

    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <style>
        .cropper-container { width: 100%; max-height: 500px; }
    </style>

    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb / Back Link -->
        <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-purple-600 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Pegawai
        </a>

        <div class="bg-white rounded-3xl shadow-xl shadow-purple-100 border border-gray-100 overflow-hidden">
            <!-- Header Banner -->
            <div class="bg-gradient-to-r from-purple-600 to-violet-600 px-8 py-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Data Pegawai</h2>
                    <p class="text-purple-100 text-sm mt-1">Perbarui informasi untuk {{ $employee->name }}.</p>
                </div>
                <div class="hidden sm:flex h-12 w-12 rounded-full bg-white/20 items-center justify-center text-white font-bold text-xl backdrop-blur-sm border border-white/30">
                    {{ substr($employee->name, 0, 1) }}
                </div>
            </div>

            <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Kolom Kiri: Informasi Dasar -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                            Data Diri
                        </h3>

                        <!-- Profile Photo Upload -->
                        <div class="flex flex-col items-center justify-center mb-4">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-purple-100 bg-gray-50 shadow-md">
                                    <img id="avatar-preview" src="{{ $employee->avatar ? asset('storage/' . $employee->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->name) . '&background=E9D5FF&color=6B21A8' }}" alt="Preview" class="w-full h-full object-cover">
                                </div>
                                <label for="avatar-input" class="absolute bottom-0 right-0 bg-purple-600 hover:bg-purple-700 text-white p-2 rounded-full shadow-lg cursor-pointer transition-all transform hover:scale-110">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">
                            </div>
                            <span class="text-xs text-gray-400 mt-2">Klik ikon kamera untuk ganti foto</span>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $employee->name }}" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm transition-all py-3 px-4 bg-gray-50/50 focus:bg-white" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                            <input type="text" name="username" value="{{ $employee->username }}" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm transition-all py-3 px-4 bg-gray-50/50 focus:bg-white" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ $employee->email }}" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm transition-all py-3 px-4 bg-gray-50/50 focus:bg-white" required>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Jabatan & Keamanan -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                            Akses & Keamanan
                        </h3>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Role / Jabatan</label>
                            <div class="relative">
                                <select name="role" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm transition-all py-3 px-4 bg-gray-50/50 focus:bg-white appearance-none">
                                    <option value="cashier" {{ $employee->role == 'cashier' ? 'selected' : '' }}>Kasir (Cashier)</option>
                                    <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>Admin Toko</option>
                                    <option value="owner" {{ $employee->role == 'owner' ? 'selected' : '' }} class="text-amber-600 font-bold">Owner (Pemilik)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Shift Kerja</label>
                            <div class="relative">
                                <select name="shift_id" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 shadow-sm transition-all py-3 px-4 bg-gray-50/50 focus:bg-white appearance-none">
                                    <option value="">-- Pilih Shift (Opsional) --</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ $employee->shift_id == $shift->id ? 'selected' : '' }}>{{ $shift->name }} ({{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }})</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="p-4 rounded-2xl bg-orange-50 border border-orange-100 mt-4">
                            <h4 class="text-sm font-bold text-orange-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Ubah Password (Opsional)
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-password-input name="password" placeholder="Password Baru" />
                                </div>
                                <div>
                                    <x-password-input name="password_confirmation" id="password_confirmation" placeholder="Ulangi Password" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ route('employees.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-purple-600 text-white text-sm font-bold shadow-lg shadow-purple-500/30 hover:bg-purple-700 hover:shadow-purple-500/50 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Crop Modal -->
    <div id="crop-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Foto Profil</h3>
                            <div class="mt-4">
                                <div class="w-full h-64 bg-gray-100 rounded-lg overflow-hidden">
                                    <img id="image-to-crop" class="w-full h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="crop-button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Potong & Simpan
                    </button>
                    <button type="button" id="cancel-crop" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const avatarInput = document.getElementById('avatar-input');
            const avatarPreview = document.getElementById('avatar-preview');
            const cropModal = document.getElementById('crop-modal');
            const imageToCrop = document.getElementById('image-to-crop');
            const cropButton = document.getElementById('crop-button');
            const cancelCrop = document.getElementById('cancel-crop');
            let cropper;

            avatarInput.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function (e) {
                        imageToCrop.src = e.target.result;
                        cropModal.classList.remove('hidden');
                        
                        // Destroy previous cropper instance if exists
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Initialize Cropper
                        cropper = new Cropper(imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            cropButton.addEventListener('click', function () {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 400,
                        height: 400,
                    });

                    canvas.toBlob(function (blob) {
                        // Create a new File object
                        const file = new File([blob], 'avatar.jpg', { type: 'image/jpeg' });
                        
                        // Create a DataTransfer to update the file input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        avatarInput.files = dataTransfer.files;

                        // Update preview
                        avatarPreview.src = canvas.toDataURL();
                        
                        // Close modal
                        cropModal.classList.add('hidden');
                    }, 'image/jpeg');
                }
            });

            cancelCrop.addEventListener('click', function () {
                cropModal.classList.add('hidden');
                avatarInput.value = ''; // Reset input if cancelled
            });
        });
    </script>
</x-app-layout>