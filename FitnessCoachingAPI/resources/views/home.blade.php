@extends('layouts.app')

@section('title', 'Home - Fitness Coaching')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white py-24 md:py-32 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in">
            <div class="inline-block mb-6">
                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold border border-white/30">
                    🏋️ Professional Fitness Coaching
                </span>
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                Transform Your<br/>
                <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">Fitness Journey</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto text-white/90 leading-relaxed">
                Professional coaching, personalized meal plans, structured workouts, and real results. 
                Join thousands achieving their fitness goals.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="group bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 hover:shadow-2xl hover:scale-105 hover:-translate-y-1 transition-all duration-300 transform inline-flex items-center space-x-2">
                    <span>Get Started Free</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#about" class="border-2 border-white/80 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 hover:border-white hover:shadow-xl hover:scale-105 hover:-translate-y-1 transition-all duration-300 transform backdrop-blur-sm">
                    Learn More
                </a>
            </div>
            
            <!-- Stats (Vue-powered, same design) -->
            <div
                id="home-hero-stats-root"
                data-active-clients="1000+"
                data-expert-coaches="50+"
                data-success-rate="95%"
            ></div>
        </div>
    </div>
</section>

<!-- About Section (Vue-powered) -->
<div id="home-about-root"></div>

<!-- Fitness Programs Section (Vue-powered) -->
<div id="home-programs-root"></div>

<!-- Success Stories Section (Vue-powered) -->
<div id="home-success-root"></div>

<!-- Services Section (Vue-powered) -->
<div id="home-services-root"></div>

<!-- Coaches Section (Vue-powered) -->
<div
    id="home-coaches-root"
    data-coaches="{{ json_encode($coaches->map(function($coach) { return ['id' => $coach->id, 'full_name' => $coach->full_name, 'clients_count' => $coach->clients_count, 'quotes' => $coach->quotes]; })) }}"
    data-register-url="{{ route('register') }}"
></div>

<!-- CTA Section (Vue-powered) -->
<div id="home-cta-root" data-register-url="{{ route('register') }}"></div>

<!-- Service Modal (Vue-powered) -->
<div id="service-modal-root" data-register-url="{{ route('register') }}"></div>

<script>
    // Additional smooth scroll handling for home page specific links
    document.addEventListener('DOMContentLoaded', function() {
        // Handle hash links on the home page
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const hash = this.getAttribute('href').substring(1);
                const target = document.getElementById(hash);
                if (target) {
                    const navHeight = 64;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    history.pushState(null, null, '#' + hash);
                }
            });
        });
    });

    // Service modal functions are now handled by Vue component
    // showServiceModal and closeServiceModal are exposed globally by ServiceModal.vue
</script>
@endsection

