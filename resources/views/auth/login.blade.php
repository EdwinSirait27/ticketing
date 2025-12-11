<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Login - IT Departments Ticketing</title>

    {{-- Tailwind --}}
    @vite('resources/css/app.css')

    {{-- PWA --}}
    <meta name="theme-color" content="#0F172A">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-slate-950 text-gray-100">
    {{-- APP CONTAINER --}}
    <div class="max-w-md mx-auto min-h-screen bg-slate-900 shadow-2xl flex flex-col">
        {{-- HEADER SECTION --}}
        <div
            class="relative px-6 pt-12 pb-8 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 border-b border-slate-800">
            {{-- Logo & Branding --}}
            <div class="flex flex-col items-center space-y--1">
                {{-- Company Logo --}}
                <div class="relative">
                    {{-- <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-2xl shadow-blue-500/30 animate-pulse-slow"> --}}
                    {{-- <svg class="w-11 h-11 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg> --}}
                    <img src="https://cloud.mjm-bali.co.id/index.php/s/7ixWakyMn8JCe9F/download"
                        class="w-25 h-25 select-none pointer-events-none" draggable="false" alt="icon">

                    {{-- </div> --}}
                    {{-- <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-3 border-slate-900"></div> --}}
                </div>

                {{-- Company Name --}}
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-white tracking-tight">Information Technology</h1>
                    <p class="text-sm text-slate-400 font-medium mt-1">Ticketing</p>
                </div>
            </div>

            {{-- Decorative Elements --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-cyan-600/10 rounded-full blur-3xl"></div>
        </div>
        

        {{-- LOGIN FORM SECTION --}}
        <div class="flex-1 px-6 py-8">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-sm text-slate-400">Log in to access the ticket system</p>
            </div>

            {{-- <form method="POST" action="#" class="space-y-5"> --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Input --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-300 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" required
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="your hr system username" value="{{ old('username') }}">
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                {{-- <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="••••••••"
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div> --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <!-- ICON PASSWORD -->
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>

                        <!-- INPUT PASSWORD -->
                        <input type="password" id="password" name="password" required
                            class="w-full pl-12 pr-12 py-3.5 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="••••••••">

                        <!-- ICON SHOW / HIDE -->
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500">
                            <!-- EYE (SHOW) -->
                            <svg id="iconShow" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- EYE SLASH (HIDE) -->
                            <svg id="iconHide" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.971 9.971 0 012.241-3.592M6.1 6.1A9.97 9.97 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-1.228 2.592M15 12a3 3 0 00-4.243-2.829M9.88 9.88A3 3 0 0112 15c.395 0 .77-.077 1.118-.218M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    document.getElementById('togglePassword').addEventListener('click', function() {
                        const input = document.getElementById('password');
                        const iconShow = document.getElementById('iconShow');
                        const iconHide = document.getElementById('iconHide');

                        if (input.type === "password") {
                            input.type = "text";
                            iconShow.classList.add('hidden');
                            iconHide.classList.remove('hidden');
                        } else {
                            input.type = "password";
                            iconShow.classList.remove('hidden');
                            iconHide.classList.add('hidden');
                        }
                    });
                </script>


                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    {{-- <label class="flex items-center cursor-pointer group">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 focus:ring-offset-slate-900"
                        >
                        <span class="ml-2 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Ingat saya</span>
                    </label> --}}

                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300 transition-colors font-medium">
                        {{-- <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition-colors font-medium"> --}}
                        Forgot Password?
                    </a>
                </div>
                {{-- Login Button --}}
                <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center space-x-2">
                    <span>Login</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>

                {{-- Divider --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-800"></div>
                    </div>

                </div>

                {{-- SSO Login (Optional) --}}
                {{-- <button 
                    type="button" 
                    class="w-full py-3.5 bg-slate-800 hover:bg-slate-750 border border-slate-700 text-slate-300 font-medium rounded-xl transition-all duration-200 flex items-center justify-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                    </svg>
                    <span>Masuk dengan Google SSO</span>
                </button> --}}

            </form>
        </div>

        {{-- FOOTER --}}
        <div class="px-6 py-6 border-t border-slate-800">
            <p class="text-center text-sm text-slate-500">
                &copy; 2025 IT Department, Developed by Edwin Sirait
            </p>
            {{-- <div class="flex justify-center space-x-4 mt-3">
                <a href="#" class="text-xs text-slate-500 hover:text-slate-400 transition-colors">Kebijakan Privasi</a>
                <span class="text-slate-700">•</span>
                <a href="#" class="text-xs text-slate-500 hover:text-slate-400 transition-colors">Syarat & Ketentuan</a>
            </div> --}}
        </div>

    </div>

    {{-- Background Decoration --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-900/20 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-900/20 rounded-full filter blur-3xl"></div>
    </div>

    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 -z-10 opacity-[0.02] pointer-events-none"
        style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 50px 50px;">
    </div>

    <style>
        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>

</body>

</html>
