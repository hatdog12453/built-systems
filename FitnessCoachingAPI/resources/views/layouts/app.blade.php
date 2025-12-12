<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fitness Coaching')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
        .animate-scale-in {
            animation: scaleIn 0.5s ease-out;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in,
            .animate-slide-in,
            .animate-slide-up,
            .animate-scale-in,
            .animate-float {
                animation: none;
            }
        }
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }
        /* Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #6366f1 #f1f5f9;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .gradient-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="glass-effect border-b border-gray-200/50 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" onclick="handleHomeClick(event)" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">FitnessCoaching</span>
                    </a>
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('home') }}" onclick="handleHomeClick(event)" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Home</a>
                        <a href="{{ route('home') }}#about" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">About</a>
                        <a href="{{ route('home') }}#services" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Services</a>
                        <a href="{{ route('home') }}#coaches" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Coaches</a>
                    </div>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:flex items-center space-x-4">
                    @if(Session::has('user'))
                        <div class="flex items-center space-x-3">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ Session::get('user')->full_name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Session::get('role') }}</p>
                            </div>
                            <a href="{{ route(Session::get('role') . '.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors duration-200">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Log In</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            Get Started
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuButton" class="sm:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200" onclick="toggleMobileMenu()">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden sm:hidden pb-4 border-t border-gray-200 mt-2">
                <div class="flex flex-col space-y-2 pt-4">
                    <a href="{{ route('home') }}" onclick="handleHomeClick(event)" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Home</a>
                    <a href="{{ route('home') }}#about" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">About</a>
                    <a href="{{ route('home') }}#services" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Services</a>
                    <a href="{{ route('home') }}#coaches" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200">Coaches</a>
                    
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        @if(Session::has('user'))
                            <div class="px-4 py-2 mb-2">
                                <p class="text-sm font-semibold text-gray-900">{{ Session::get('user')->full_name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Session::get('role') }}</p>
                            </div>
                            <a href="{{ route(Session::get('role') . '.dashboard') }}" class="block px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-200 text-center mb-2">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors duration-200 text-center">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors duration-200 text-center mb-2">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-200 text-center">
                                Get Started
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages (Vue-powered, same design) -->
    <div
        id="flash-messages-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        class="fixed top-24 right-4 z-50 space-y-2 max-w-md"
    ></div>

    <!-- Main Content -->
    <main class="animate-fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">FitnessCoaching</span>
                    </div>
                    <p class="text-gray-400 max-w-md">
                        Transform your fitness journey with personalized coaching, comprehensive meal plans, and structured workout sessions.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Services</a></li>
                        <li><a href="{{ route('home') }}#coaches" class="hover:text-white transition-colors">Coaches</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Account</h3>
                    <ul class="space-y-2 text-gray-400">
                        @if(Session::has('user'))
                            <li><a href="{{ route(Session::get('role') . '.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Fitness Coaching. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');
            
            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    document.getElementById('menuIcon').classList.remove('hidden');
                    document.getElementById('closeIcon').classList.add('hidden');
                }
            }
        });

        // Handle Home link click
        function handleHomeClick(event) {
            const homePath = '{{ route("home") }}';
            const currentPath = window.location.pathname;
            
            if (currentPath === homePath || currentPath === '/') {
                event.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                if (window.location.hash) {
                    history.pushState(null, null, window.location.pathname);
                }
            }
        }
        
        // Smooth scroll for navigation links
        document.addEventListener('DOMContentLoaded', function() {
            function scrollToElement(hash, smooth = true) {
                const target = document.getElementById(hash);
                if (target) {
                    const navHeight = 80;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({ top: targetPosition, behavior: smooth ? 'smooth' : 'auto' });
                }
            }
            
            document.querySelectorAll('a[href*="{{ route("home") }}"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    const currentPath = window.location.pathname;
                    const homePath = '{{ route("home") }}';
                    
                    if (currentPath !== homePath && currentPath !== '/') {
                        return;
                    }
                    
                    if (href.includes('#')) {
                        e.preventDefault();
                        const hash = href.split('#')[1];
                        if (hash) {
                            scrollToElement(hash, true);
                            history.pushState(null, null, '#' + hash);
                        }
                    }
                });
            });
            
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                setTimeout(() => scrollToElement(hash, true), 100);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
