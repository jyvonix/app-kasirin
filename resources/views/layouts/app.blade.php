<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kasirin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- SweetAlert2 (Premium Notifications) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- QRCode JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F8FAFC] text-gray-900" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- SIDEBAR -->
            <!-- Mobile Backdrop -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-[#251A4A]/50 backdrop-blur-sm transition-opacity md:hidden" style="display: none;"></div>
            
            <!-- Sidebar Component -->
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-72 transform transition duration-300 md:relative md:translate-x-0">
                @include('layouts.sidebar')
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="flex-1 flex flex-col overflow-hidden relative bg-[#F8FAFC]">
                
                <!-- TOPBAR -->
                @include('layouts.topbar', ['title' => $header ?? null])

                <!-- SCROLLABLE CONTENT -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
                    <!-- Page Content -->
                    {{ $slot }}
                </main>
            </div>

        </div>

        <!-- SweetAlert2 Trigger Script -->
        <script>
            // 1. Toast Notification Configuration (Super Premium)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast',
                    title: 'font-bold'
                }
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    background: '#ffffff', // Clean White
                    color: '#4338ca', // Indigo Text
                    iconColor: '#4f46e5' // Indigo Icon
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}",
                    background: '#ffffff',
                    color: '#991b1b', // Red Text
                    iconColor: '#ef4444' // Red Icon
                });
            @endif

            @if($errors->any())
                Toast.fire({
                    icon: 'error',
                    title: "{{ $errors->first() }}",
                    background: '#ffffff',
                    color: '#991b1b',
                    iconColor: '#ef4444'
                });
            @endif

            // 2. Global Delete Confirmation (The "Anti-Jadul" Script)
            document.addEventListener('DOMContentLoaded', function () {
                // Logout Confirmation
                const logoutForms = document.querySelectorAll('.logout-confirm');
                logoutForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Ingin Keluar?',
                            text: "Anda harus login kembali untuk mengakses sistem.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#4f46e5', // Indigo
                            cancelButtonColor: '#f3f4f6', // Gray
                            confirmButtonText: 'Ya, Keluar!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl border border-gray-100',
                                confirmButton: 'swal-confirm-btn-indigo',
                                cancelButton: 'swal-cancel-btn',
                                title: 'text-xl font-bold text-gray-800',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });

                const deleteForms = document.querySelectorAll('.delete-form');
                
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault(); // Stop form submission

                        Swal.fire({
                            title: 'Hapus Item Ini?',
                            text: "Data yang dihapus tidak dapat dikembalikan lagi!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33', // Merah
                            cancelButtonColor: '#3085d6', // Biru
                            confirmButtonText: 'Ya, Hapus Saja!',
                            cancelButtonText: 'Batal',
                            background: '#ffffff',
                            color: '#1f2937',
                            width: '400px',
                            padding: '1.5rem',
                            reverseButtons: true, 
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl border border-gray-100',
                                confirmButton: 'swal-confirm-btn',
                                cancelButton: 'swal-cancel-btn',
                                title: 'text-xl font-bold text-gray-800',
                                htmlContainer: 'text-sm text-gray-500'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit(); // Lanjutkan submit form manual
                            }
                        });
                    });
                });
            });

            // 3. Global Show My QR Function (Premium ID Card)
            function showMyQr() {
                const token = "{{ Auth::user()->qr_token ?? '' }}";
                const name = "{{ Auth::user()->name ?? 'User' }}";
                const role = "{{ ucfirst(Auth::user()->role ?? 'Staff') }}";
                
                if(!token) return;

                Swal.fire({
                    html: `
                        <div class="relative overflow-hidden bg-white rounded-3xl p-6 shadow-none">
                            <!-- Header Card -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-[#4C3494] rounded-lg flex items-center justify-center text-white shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    </div>
                                    <span class="font-bold text-[#251A4A] tracking-tight">KASIRIN ID</span>
                                </div>
                                <span class="bg-[#00D5C3]/10 text-[#00D5C3] text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">${role}</span>
                            </div>

                            <!-- QR Container -->
                            <div class="flex justify-center my-4 relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#4C3494] to-[#7F30C9] opacity-10 blur-xl rounded-full transform scale-110"></div>
                                <div id="my-qrcode" class="bg-white p-3 rounded-2xl shadow-xl border-4 border-[#F8FAFC] relative z-10"></div>
                            </div>

                            <!-- Footer Info -->
                            <div class="text-center mt-6">
                                <h3 class="text-xl font-black text-[#251A4A] tracking-tight">${name}</h3>
                                <p class="text-xs text-gray-400 mt-1 font-medium">Scan kode ini untuk absensi harian.</p>
                            </div>
                            
                            <!-- Bottom Deco -->
                            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#4C3494] via-[#00D5C3] to-[#4C3494]"></div>
                        </div>
                    `,
                    showCloseButton: false,
                    showConfirmButton: false,
                    width: '380px',
                    padding: '0',
                    background: 'transparent', // Transparent agar border radius card yang mengatur
                    backdrop: `rgba(37, 26, 74, 0.8)`, // Dark Purple Backdrop
                    didOpen: () => {
                        // Clear previous QR if any (fix double QR bug)
                        document.getElementById("my-qrcode").innerHTML = "";
                        new QRCode(document.getElementById("my-qrcode"), {
                            text: token,
                            width: 180,
                            height: 180,
                            colorDark : "#251A4A",
                            colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.H
                        });
                    }
                });
            }
        </script>

        <!-- Custom Style for SweetAlert Buttons to match Tailwind -->
        <style>
            .swal2-popup {
                font-family: 'Figtree', sans-serif !important;
            }
            .swal2-title {
                margin-top: 1rem !important;
            }
            .swal-confirm-btn {
                background-color: #ef4444 !important; /* Tailwind Red-500 */
                border-radius: 0.75rem !important;
                padding: 10px 24px !important;
                font-weight: 700 !important;
                box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.4) !important;
            }
            .swal-confirm-btn-indigo {
                background-color: #4f46e5 !important; /* Tailwind Indigo-600 */
                color: white !important;
                border-radius: 0.75rem !important;
                padding: 10px 24px !important;
                font-weight: 700 !important;
                box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.4) !important;
            }
            .swal-cancel-btn {
                background-color: #f3f4f6 !important; /* Tailwind Gray-100 */
                color: #374151 !important; /* Tailwind Gray-700 */
                border-radius: 0.75rem !important;
                padding: 10px 24px !important;
                font-weight: 600 !important;
                margin-right: 1rem !important;
            }
            .swal-cancel-btn:hover {
                background-color: #e5e7eb !important;
            }
            /* Toast Styling */
            .colored-toast {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
                border-radius: 1rem !important;
                border-left: 6px solid #4f46e5 !important; /* Aksen Ungu Kiri */
            }

            /* Premium Custom Scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(0, 213, 195, 0.3); /* Cyan semi-transparent */
                border-radius: 10px;
                transition: all 0.3s ease;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(0, 213, 195, 0.8); /* Cyan solid on hover */
            }
            /* For Firefox */
            .custom-scrollbar {
                scrollbar-width: thin;
                scrollbar-color: rgba(0, 213, 195, 0.3) rgba(255, 255, 255, 0.05);
            }
        </style>
    </body>
</html>
