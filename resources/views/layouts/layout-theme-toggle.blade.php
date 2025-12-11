<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title', 'Enterprise Ticketing')</title>

    {{-- Tailwind --}}
    @vite('resources/css/app.css')

    {{-- PWA --}}
    <meta name="theme-color" content="#0F172A">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* small helper to avoid flash before JS runs */
        html:not(.dark) body[data-cloak] { visibility: hidden; }
        html.dark body[data-cloak] { visibility: hidden; }
    </style>
</head>

<body data-cloak class="bg-white text-slate-900 dark:bg-slate-950 dark:text-gray-100 transition-colors duration-300">

    {{-- APP CONTAINER --}}
    <div class="max-w-md mx-auto min-h-screen bg-white dark:bg-slate-900 shadow-2xl transition-colors duration-300">

        {{-- HEADER --}}
        <header class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-300 dark:border-slate-800">
            <div class="px-6 py-4">
                {{-- Logo & Company Name --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        {{-- Company Logo --}}
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-slate-900 animate-pulse"></div>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">@yield('company', 'ENTERPRISE')</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Service Desk</p>
                        </div>
                    </div>

                    {{-- Controls: Theme toggle + Profile --}}
                    <div class="flex items-center space-x-3">

                        <!-- Theme Toggle Button -->
                        <button id="themeToggle" aria-label="Toggle theme" type="button"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 ring-1 ring-slate-200 dark:ring-slate-700 transition-shadow transition-colors duration-300">
                            <!-- Sun -->
                            <svg id="sunIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m0-11.314L7.05 7.05m9.9 9.9l1.414 1.414"></path>
                            </svg>

                            <!-- Moon -->
                            <svg id="moonIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                            </svg>
                        </button>

                        {{-- Profile --}}
                        <a href="#" class="relative group">
                            <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 transition-colors duration-300 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </a>

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
        <main class="pb-24 pt-6 px-6">
            @yield('content')
        </main>

        {{-- BOTTOM NAV --}}
        @include('components.bottom-nav')

    </div>

    {{-- Background Decoration --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-900/20 dark:bg-blue-800/20 rounded-full filter blur-3xl transition-opacity duration-300"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-900/20 dark:bg-cyan-800/20 rounded-full filter blur-3xl transition-opacity duration-300"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-slate-800/30 dark:bg-slate-700/30 rounded-full filter blur-3xl transition-opacity duration-300"></div>
    </div>

    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 -z-10 opacity-[0.02] pointer-events-none" style="background-image: linear-gradient(#000 1px, transparent 1px), linear-gradient(90deg, #000 1px, transparent 1px); background-size: 50px 50px; mix-blend-mode: multiply;"></div>


    {{-- Theme Script: auto-detect, toggle, persist, and react to system changes --}}
    <script>
        (function () {
            const html = document.documentElement;
            const body = document.body;
            const toggleBtn = document.getElementById('themeToggle');
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');

            // Helper: apply icons
            function updateIcons() {
                if (html.classList.contains('dark')) {
                    moonIcon.classList.remove('hidden');
                    sunIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }

            // Read saved preference
            const saved = localStorage.getItem('theme');

            // Apply initial theme: localStorage > OS preference > default light
            function applyInitialTheme() {
                if (saved === 'light') {
                    html.classList.remove('dark');
                } else if (saved === 'dark') {
                    html.classList.add('dark');
                } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }

                // remove cloaking so UI becomes visible
                body.removeAttribute('data-cloak');
                updateIcons();
            }

            applyInitialTheme();

            // Toggle button
            toggleBtn.addEventListener('click', function () {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateIcons();
            });

            // Respond to OS preference changes only if user hasn't saved a preference
            if (window.matchMedia) {
                const mq = window.matchMedia('(prefers-color-scheme: dark)');
                mq.addEventListener('change', (e) => {
                    const savedNow = localStorage.getItem('theme');
                    if (savedNow === null) { // no explicit user pref => follow system
                        if (e.matches) html.classList.add('dark');
                        else html.classList.remove('dark');
                        updateIcons();
                    }
                });
            }

            // Accessibility: keyboard toggle (Enter / Space)
            toggleBtn.addEventListener('keyup', function (e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    toggleBtn.click();
                }
            });

        })();
    </script>

</body>
</html>
