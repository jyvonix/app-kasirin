<x-app-layout>
    <x-slot name="header">Pengajuan Izin / Sakit</x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                
                <!-- Gradient Header -->
                <div class="bg-gradient-to-r from-purple-800 to-indigo-900 p-6 text-white">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Form Pengajuan Ketidakhadiran
                    </h2>
                    <p class="text-indigo-200 text-sm mt-1">Silakan isi formulir di bawah ini dengan jujur dan lengkap.</p>
                </div>

                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 font-bold">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-bold">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('attendance.leave') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Nama Pegawai (Read Only) -->
                        <div>
                            <x-input-label for="name" value="Nama Pegawai" />
                            <div class="mt-1 flex rounded-xl shadow-sm border border-gray-200 bg-gray-50 h-12 items-center px-4 text-gray-600 font-bold">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ Auth::user()->name }}
                            </div>
                        </div>

                        <!-- Jenis Izin -->
                        <div>
                            <x-input-label for="status" value="Jenis Pengajuan" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm h-12">
                                <option value="sick">🤒 Sakit</option>
                                <option value="permit">📝 Izin (Keperluan Pribadi)</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <x-input-label for="note" value="Alasan / Keterangan Lengkap" />
                            <textarea id="note" name="note" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" placeholder="Contoh: Demam tinggi sejak semalam..." required></textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <!-- Upload Bukti -->
                        <div>
                            <x-input-label for="attachment" value="Upload Bukti (Surat Dokter / Foto)" />
                            <div id="upload-container" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition relative group">
                                <div class="space-y-1 text-center" id="upload-placeholder">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="attachment" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Pilih file</span>
                                            <input id="attachment" name="attachment" type="file" class="sr-only" onchange="handleFileSelect(this)">
                                        </label>
                                        <p class="pl-1">atau tarik ke sini</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF up to 2MB
                                    </p>
                                </div>

                                <!-- Preview Area (Hidden initially) -->
                                <div id="upload-preview" class="hidden flex-col items-center">
                                    <div class="relative inline-block">
                                        <img id="preview-img" src="#" class="h-24 w-auto rounded-lg shadow-md mb-2 hidden">
                                        <div id="preview-pdf" class="h-16 w-16 bg-red-100 rounded-lg flex items-center justify-center mb-2 hidden">
                                            <span class="text-red-600 font-bold text-xs uppercase tracking-widest">PDF</span>
                                        </div>
                                    </div>
                                    <p id="filename-display" class="text-sm font-bold text-indigo-600 truncate max-w-xs"></p>
                                    <button type="button" onclick="resetUpload()" class="mt-2 text-xs text-red-500 font-medium hover:underline">Hapus & Ganti</button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-1">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>

                    <script>
                        function handleFileSelect(input) {
                            const container = document.getElementById('upload-container');
                            const placeholder = document.getElementById('upload-placeholder');
                            const preview = document.getElementById('upload-preview');
                            const img = document.getElementById('preview-img');
                            const pdfIcon = document.getElementById('preview-pdf');
                            const filename = document.getElementById('filename-display');

                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                filename.innerText = file.name;
                                
                                placeholder.classList.add('hidden');
                                preview.classList.remove('hidden');
                                container.classList.add('bg-indigo-50/50', 'border-indigo-300');

                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        img.src = e.target.result;
                                        img.classList.remove('hidden');
                                        pdfIcon.classList.add('hidden');
                                    }
                                    reader.readAsDataURL(file);
                                } else if (file.type === 'application/pdf') {
                                    img.classList.add('hidden');
                                    pdfIcon.classList.remove('hidden');
                                }
                            }
                        }

                        function resetUpload() {
                            const input = document.getElementById('attachment');
                            const container = document.getElementById('upload-container');
                            const placeholder = document.getElementById('upload-placeholder');
                            const preview = document.getElementById('upload-preview');
                            
                            input.value = '';
                            placeholder.classList.remove('hidden');
                            preview.classList.add('hidden');
                            container.classList.remove('bg-indigo-50/50', 'border-indigo-300');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
