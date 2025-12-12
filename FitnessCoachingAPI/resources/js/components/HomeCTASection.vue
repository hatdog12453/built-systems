<template>
    <section class="relative py-24 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold mb-6">Ready to Transform Your Life?</h2>
            <p class="text-xl md:text-2xl mb-10 text-white/90 max-w-2xl mx-auto leading-relaxed">
                Join thousands of satisfied clients who have achieved their fitness goals. 
                Start your transformation today with a personalized coaching plan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a :href="registerUrl" class="group bg-white text-indigo-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 hover:shadow-2xl hover:scale-105 hover:-translate-y-1 transition-all duration-300 transform inline-flex items-center space-x-2">
                    <span>Get Started Free</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#about" class="border-2 border-white/80 text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white/10 hover:border-white hover:shadow-xl hover:scale-105 hover:-translate-y-1 transition-all duration-300 transform backdrop-blur-sm">
                    Learn More
                </a>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    registerUrl: { type: String, default: '/register' },
});
</script>

