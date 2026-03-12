<x-app-layout>
    <x-slot name="header">Scanner Absensi</x-slot>

    <!-- HTML5-QRCode Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="max-w-7xl mx-auto h-[calc(100vh-100px)] flex flex-col md:flex-row gap-6 p-4">
        
        <!-- BAGIAN KIRI: Kamera & Input Manual -->
        <div class="flex-1 flex flex-col gap-4">
            
            <!-- Camera Container -->
            <div class="flex-1 bg-black rounded-3xl shadow-2xl overflow-hidden relative border-4 border-[#251A4A] group">
                <div id="reader" class="w-full h-full object-cover bg-black"></div>
                
                <!-- Overlay UI -->
                <div class="absolute inset-0 pointer-events-none flex flex-col justify-between p-6 z-10">
                    <div class="flex justify-between items-start">
                        <div class="bg-black/60 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse" id="camera-dot"></div>
                            <span class="text-white text-xs font-bold tracking-widest uppercase">Live Scan</span>
                        </div>
                    </div>
                    
                    <!-- Pesan Bantuan -->
                    <div class="text-center">
                        <p class="text-white/90 text-sm bg-black/60 backdrop-blur-md inline-block px-6 py-3 rounded-2xl border border-white/10 shadow-lg" id="scan-message">
                            Arahkan kamera ke QR Code
                        </p>
                    </div>
                </div>
            </div>

            <!-- Input Manual (Backup) -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex gap-3">
                <input type="text" id="manual-code" placeholder="Gagal scan? Ketik kode QR di sini..." 
                    class="flex-1 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 text-sm"
                    onkeypress="handleManualEnter(event)">
                <button onclick="processManualCode()" 
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-xl text-sm font-bold transition shadow-lg shadow-purple-200">
                    Absen Manual
                </button>
            </div>
        </div>

        <!-- BAGIAN KANAN: Panel Info & Log -->
        <div class="w-full md:w-96 flex flex-col gap-6">
            
            <!-- Clock Widget -->
            <div class="bg-gradient-to-br from-[#4C3494] to-[#251A4A] rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-[#00D5C3] rounded-full blur-[80px] opacity-20"></div>
                <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-1">Waktu Server</p>
                <h2 class="text-5xl font-black tracking-tight" id="clock">00:00</h2>
                <p class="text-sm font-medium opacity-80 mt-2">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>

            <!-- Status Box -->
            <div class="flex-1 bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div id="result-container" class="hidden w-full h-full flex flex-col items-center justify-center animate-fade-in">
                    <div id="result-icon-bg" class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 ring-8 ring-green-50 transition-all duration-300">
                        <svg id="result-icon" class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900" id="result-user">Nama Pegawai</h4>
                    <div class="mt-2 px-4 py-1 rounded-full bg-gray-100 inline-block">
                        <p class="text-gray-600 font-bold text-sm uppercase tracking-wide" id="result-action">Masuk</p>
                    </div>
                    <p class="text-gray-400 text-sm mt-4" id="result-message">Pesan sistem...</p>
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="flex flex-col items-center justify-center opacity-40">
                    <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h2v-4H6v4zM6 20v-4m2 0h2v4h-2zM6 20h2m2-4h2v4h-2v-4zM6 4h2v4H6V4zm2 0h2v4H8V4zm2 0h2v4h-2V4zm-4 6h2v4H6v-4zm2 0h2v4H8v-4zm2 0h2v4h-2v-4z"></path></svg>
                    <p class="text-gray-500 font-medium">Menunggu Scan...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Feedback -->
    <audio id="success-sound" src="https://assets.mixkit.co/active_storage/sfx/2578/2578-preview.mp3"></audio>
    <audio id="error-sound" src="https://assets.mixkit.co/active_storage/sfx/2572/2572-preview.mp3"></audio>

    <style>
        #reader video {
            object-fit: cover !important;
            border-radius: 1.5rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Realtime Clock
        setInterval(() => {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }, 1000);

        let isProcessing = false;
        const html5QrCode = new Html5Qrcode("reader");
        const successSound = document.getElementById('success-sound');
        const errorSound = document.getElementById('error-sound');

        // 2. Core Processing Function
        function processAttendance(code) {
            if (isProcessing) return;
            isProcessing = true;

            // UI Feedback: Processing
            document.getElementById('scan-message').innerText = "Memproses data...";
            document.getElementById('camera-dot').className = "w-2 h-2 rounded-full bg-yellow-400 animate-pulse";

            fetch('{{ route('scan.process') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_token: code })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
                if (data.status === 'success' || data.status === 'warning') {
                    document.getElementById('manual-code').value = ''; 
                    successSound.play().catch(e => console.log('Audio play failed', e));
                } else {
                    errorSound.play().catch(e => console.log('Audio play failed', e));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({ status: 'error', message: 'Terjadi kesalahan koneksi.', user_name: 'Error', action: 'Gagal' });
            })
            .finally(() => {
                setTimeout(() => {
                    isProcessing = false;
                    document.getElementById('scan-message').innerText = "Arahkan kamera ke QR Code";
                    document.getElementById('camera-dot').className = "w-2 h-2 rounded-full bg-red-500 animate-pulse";
                }, 3000);
            });
        }

        // 3. UI Result Handler
        function showResult(data) {
            const emptyState = document.getElementById('empty-state');
            const resultContainer = document.getElementById('result-container');
            const iconBg = document.getElementById('result-icon-bg');
            const icon = document.getElementById('result-icon');
            
            emptyState.classList.add('hidden');
            resultContainer.classList.remove('hidden');

            document.getElementById('result-user').innerText = data.user_name || 'Tidak Dikenal';
            document.getElementById('result-action').innerText = data.action || 'Error';
            document.getElementById('result-message').innerText = data.message;

            iconBg.className = "w-24 h-24 rounded-full flex items-center justify-center mb-6 ring-8 transition-all duration-300";
            
            if (data.status === 'success') {
                iconBg.classList.add('bg-green-100', 'ring-green-50', 'text-green-500');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>';
            } else if (data.status === 'warning') {
                iconBg.classList.add('bg-yellow-100', 'ring-yellow-50', 'text-yellow-600');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
            } else {
                iconBg.classList.add('bg-red-100', 'ring-red-50', 'text-red-500');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>';
            }
        }

        // 4. QR Code Config - NO DISTORTION & FAST DETECTION
        const config = { 
            fps: 25,
            qrbox: (vw, vh) => {
                let size = Math.min(vw, vh) * 0.75;
                return { width: size, height: size };
            },
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
            }
        };

        const onScanSuccess = (decodedText) => {
            if (!isProcessing) {
                if (navigator.vibrate) navigator.vibrate(100);
                processAttendance(decodedText);
            }
        };

        // Start Scanner
        async function startScanner() {
            try {
                try { await html5QrCode.stop(); } catch(e) {}
                await html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);
                document.getElementById('scan-message').innerText = "Kamera Aktif - Siap Scan";
            } catch (err) {
                console.error("Scanner Error:", err);
                html5QrCode.start({ facingMode: "environment" }, { fps: 15 }, onScanSuccess)
                    .catch(e => showCameraError("Gagal Mengakses Kamera", "Pastikan izin diberikan dan refresh halaman."));
            }
        }

        function showCameraError(title, desc) {
            document.getElementById('reader').innerHTML = `
                <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-gray-900/60 backdrop-blur-sm">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-white font-bold mb-1">${title}</p>
                    <p class="text-gray-400 text-xs mb-4">${desc}</p>
                    <button onclick="location.reload()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-lg">
                        Refresh Halaman
                    </button>
                </div>
            `;
        }

        // 5. Manual Input Handler
        function processManualCode() {
            const code = document.getElementById('manual-code').value.trim();
            if (code !== "") processAttendance(code);
        }

        function handleManualEnter(e) {
            if (e.key === 'Enter') processManualCode();
        }

        // Jalankan scanner
        startScanner();
    </script>
</x-app-layout>