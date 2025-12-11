<!DOCTYPE html>
<html lang="id"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'IT Departments Ticketing')</title>
    {{-- Tailwind --}}
    @vite('resources/css/app.css')
    {{-- PWA --}}
    <meta name="theme-color" content="#0F172A">
    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-gray-100 transition-colors duration-300">

    {{-- APP CONTAINER --}}
    <div class="max-w-md mx-auto min-h-screen bg-white dark:bg-slate-900 shadow-2xl transition-colors duration-300">

        {{-- HEADER --}}
        <header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
            <div class="px-6 py-4">

                {{-- Logo & Company Name --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">

                        {{-- Company Logo --}}
                        <div class="relative">
                          
                                  <img src="https://cloud.mjm-bali.co.id/index.php/s/7ixWakyMn8JCe9F/download"
                        class="w-20 h-20 select-none pointer-events-none" draggable="false" alt="icon">
                          </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">@yield('company', 'IT Departments')</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Ticketing</p>
                        </div>
                    </div>

                </div>

                {{-- Page Title --}}
                <div class="flex items-center space-x-2">
                    <div class="h-8 w-1 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full"></div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">
                            @yield('header', 'Dashboard')
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">@yield('subtitle', 'Kelola tiket support Anda')</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="pb-24 pt-6">
            @yield('content')
        </main>

        {{-- BOTTOM NAV --}}
        @include('components.bottom-nav')

    </div>

    {{-- Background Decoration --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-300/20 dark:bg-blue-900/20 rounded-full filter blur-3xl transition-colors"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-300/20 dark:bg-cyan-900/20 rounded-full filter blur-3xl transition-colors"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-slate-300/30 dark:bg-slate-800/30 rounded-full filter blur-3xl transition-colors"></div>
    </div>

    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 -z-10 opacity-[0.05] dark:opacity-[0.02] pointer-events-none"
        style="background-image: linear-gradient(#000 1px, transparent 1px), 
               linear-gradient(90deg, #000 1px, transparent 1px);
               background-size: 50px 50px;"></div>


    {{-- THEME SCRIPT --}}
    <script>
        // Apply saved theme on load
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Toggle theme
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>

</body>
</html>
