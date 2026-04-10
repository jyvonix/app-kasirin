<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kasirin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-[#F8FAFC]">
        {{ $slot }}

        <!-- SweetAlert2 Trigger Script -->
        <script>
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
                    background: '#ffffff',
                    color: '#4338ca',
                    iconColor: '#4f46e5'
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}",
                    background: '#ffffff',
                    color: '#991b1b',
                    iconColor: '#ef4444'
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
        </script>

        <style>
            .swal2-popup {
                font-family: 'Figtree', sans-serif !important;
            }
            .colored-toast {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
                border-radius: 1rem !important;
                border-left: 6px solid #ef4444 !important; /* Default red error accent */
            }
            .swal2-icon-success + .colored-toast {
                border-left-color: #4f46e5 !important; /* Indigo accent for success */
            }
        </style>
    </body>
</html>