<x-guest-layout>
    <!-- Background Full Gradient (OVO Style) -->
    <div class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden font-sans"
         style="background: linear-gradient(135deg, #4C3494 0%, #392b58 100%);">
        
        <!-- Decorative Bubbles/Blobs (Gradasi) -->
        <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-[#9647DB] rounded-full mix-blend-screen filter blur-[80px] opacity-40 animate-blob"></div>
        <div class="absolute bottom-[-100px] right-[-100px] w-96 h-96 bg-[#00D5C3] rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute top-[30%] right-[20%] w-64 h-64 bg-[#7F00FF] rounded-full mix-blend-overlay filter blur-[60px] opacity-40 animate-blob animation-delay-4000"></div>

        <!-- Main Card -->
        <div class="w-full max-w-[400px] bg-white rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden">
            
            <!-- Header Graphic -->
            <div class="relative h-40 w-full bg-gradient-to-r from-[#4C3494] to-[#7F30C9] flex items-center justify-center overflow-hidden">
                <!-- Abstract Waves -->
                <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full blur-xl"></div>
                
                <div class="relative z-10 text-center">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto shadow-lg mb-2 text-[#4C3494]">
                        <!-- Icon Market -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <h2 class="text-white font-bold text-xl tracking-wide">KASIRIN PRO</h2>
                </div>
            </div>

            <!-- Form Container -->
            <div class="p-8 sm:p-10 bg-white">
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">Selamat Datang</h3>
                    <p class="text-gray-400 text-sm mt-1">Silakan masuk untuk memulai.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#4C3494] uppercase tracking-wider ml-2">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-20">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#9647DB] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-transparent rounded-2xl text-gray-800 font-bold placeholder-gray-400 focus:bg-white focus:border-[#00D5C3] focus:ring-2 focus:ring-[#00D5C3]/20 transition-all shadow-inner"
                                placeholder="Username ID"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1 ml-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#4C3494] uppercase tracking-wider ml-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-20">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#9647DB] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <x-password-input 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="pl-11"
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2" />
                    </div>

                    <!-- Remember Me (Simple Modern) -->
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-5 h-5 text-[#4C3494] border-gray-300 rounded focus:ring-[#00D5C3] cursor-pointer">
                            <span class="ml-2 text-sm text-gray-500 font-semibold group-hover:text-[#4C3494] transition">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Button (OVO Gradient) -->
                    <button type="submit" class="w-full py-4 rounded-2xl text-white font-bold text-lg shadow-lg hover:shadow-xl transform transition-all duration-200 hover:-translate-y-1 active:scale-95"
                        style="background: linear-gradient(to right, #4C3494, #7F30C9);">
                        MASUK
                    </button>

                </form>
            </div>
            
            <!-- Bottom Line Decoration -->
            <div class="h-2 w-full bg-gradient-to-r from-[#00D5C3] to-[#4C3494]"></div>
        </div>

        <div class="absolute bottom-6 text-white/50 text-xs font-medium">
            &copy; {{ date('Y') }} Kasirin Pro System
        </div>

    </div>

    <!-- Animation CSS -->
    <style>
        .animate-blob { animation: blob 10s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</x-guest-layout>
