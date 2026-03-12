<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - {{ $employee->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact;
        }

        @page {
            size: portrait;
            margin: 0;
        }

        @media print {
            body { background: none !important; padding: 0 !important; }
            .no-print { display: none !important; }
            .card-wrapper { margin: 0 auto; padding: 0; box-shadow: none; }
        }

        /* 1. CONTAINER KARTU - TINGGI DITAMBAH UNTUK JARAK LEBIH LEGA */
        .id-card {
            width: 75mm;
            height: 145mm; /* Ditambah agar lebih tinggi */
            background: #ffffff;
            border-radius: 40px;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 60px -10px rgba(37, 26, 74, 0.2);
        }

        /* 2. HEADER */
        .header {
            height: 28%; /* Sedikit dikurangi agar area konten lebih luas */
            background: linear-gradient(135deg, #251A4A 0%, #4C3494 100%);
            position: relative;
            display: flex;
            justify-content: center;
            padding-top: 30px;
        }

        /* 3. PROFILE PICTURE */
        .profile-container {
            position: absolute;
            bottom: -55px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
        }
        
        .avatar {
            width: 110px;
            height: 110px;
            border-radius: 40px;
            border: 8px solid #ffffff;
            background: #fff;
            object-fit: cover;
            box-shadow: 0 10px 20px rgba(37, 26, 74, 0.15);
        }

        /* 4. CONTENT AREA */
        .body-section {
            height: 72%;
            padding-top: 65px;
            padding-left: 24px;
            padding-right: 24px;
            padding-bottom: 60px; /* JARAK BAWAH DIPERBESAR SECARA SIGNIFIKAN */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 5. NAMA & ROLE */
        .identity-box {
            text-align: center;
            margin-bottom: 20px;
        }

        /* 6. KOTAK QR & CODE */
        .qr-code-box {
            background: #fdfaff;
            border: 2px solid #f3e8ff;
            border-radius: 35px;
            padding: 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px; /* MEMBERI JARAK PASTI DENGAN FOOTER */
        }

        /* 7. KODE MANUAL */
        .manual-code-tag {
            background: #4C3494;
            color: #ffffff;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 3px;
            padding: 10px 20px;
            border-radius: 15px;
            text-align: center;
            width: 100%;
            border: 2px solid #251A4A;
            box-shadow: 0 6px 15px rgba(76, 52, 148, 0.2);
        }

        /* 8. FOOTER - TERANGKAT LEBIH TINGGI */
        .footer-info {
            width: 100%;
            border-top: 2px dashed #f3e8ff;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto; /* Memastikan tetap di bawah tapi mengikuti padding body */
        }

        /* UTILS */
        .label { font-size: 8px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; }
        .value { font-size: 11px; font-weight: 800; color: #251A4A; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-10">

    <!-- Tombol Aksi -->
    <div class="no-print mb-10 flex gap-4">
        <button onclick="window.print()" class="bg-[#4C3494] text-white font-bold py-3 px-10 rounded-full shadow-xl hover:bg-[#251A4A] transition-all transform hover:-translate-y-1 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            CETAK KARTU
        </button>
        <button onclick="window.close()" class="bg-white text-gray-500 font-bold py-3 px-8 rounded-full border border-gray-200">
            TUTUP
        </button>
    </div>

    <!-- KARTU UTAMA -->
    <div class="card-wrapper">
        <div class="id-card">
            
            <!-- HEADER -->
            <div class="header">
                <div class="bg-white/10 backdrop-blur-md px-5 py-2 rounded-2xl border border-white/20 h-fit">
                    <p class="text-white text-[11px] font-black tracking-[0.4em] uppercase">KASIRIN POS</p>
                </div>
                
                <!-- PHOTO -->
                <div class="profile-container">
                    @if($employee->avatar)
                        <img src="{{ asset('storage/' . $employee->avatar) }}" class="avatar">
                    @else
                        <div class="avatar bg-purple-50 flex items-center justify-center text-[#4C3494] text-5xl font-black">
                            {{ substr($employee->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- BODY -->
            <div class="body-section">
                
                <!-- NAMA & ROLE -->
                <div class="identity-box">
                    <h2 class="text-2xl font-extrabold text-[#251A4A] leading-tight mb-2 truncate px-2">{{ $employee->name }}</h2>
                    <span class="inline-flex items-center gap-1.5 bg-purple-50 text-[#4C3494] px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-purple-100">
                        <span class="w-1.5 h-1.5 bg-[#00D5C3] rounded-full animate-pulse"></span>
                        {{ $employee->role }}
                    </span>
                </div>

                <!-- QR & CODE GROUP -->
                <div class="qr-code-box shadow-sm">
                    <!-- QR -->
                    <div class="bg-white p-2 rounded-2xl border border-purple-50">
                        <div id="qrcode"></div>
                    </div>
                    
                    <!-- MANUAL CODE -->
                    <div class="w-full">
                        <p class="text-[7px] font-bold text-center text-slate-400 uppercase tracking-[0.4em] mb-2">Manual Access Code</p>
                        <div class="manual-code-tag">
                            {{ $employee->employee_code }}
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="footer-info">
                    <div>
                        <p class="label">Shift Kerja</p>
                        <p class="value">{{ $employee->shift ? \Carbon\Carbon::parse($employee->shift->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($employee->shift->end_time)->format('H:i') : 'OFF' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="label">Member ID</p>
                        <p class="value">#{{ substr($employee->qr_token, 0, 6) }}</p>
                    </div>
                </div>

            </div>
            
            <!-- Garis Hiasan Bawah -->
            <div class="h-3 w-full bg-gradient-to-r from-[#00D5C3] via-[#4C3494] to-[#251A4A]"></div>
        </div>
    </div>

    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $employee->qr_token }}",
            width: 100,
            height: 100,
            colorDark : "#251A4A",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>