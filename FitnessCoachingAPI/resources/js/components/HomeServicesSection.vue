<template>
    <section id="services" class="py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full text-sm font-semibold mb-4">What We Offer</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Our Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Comprehensive fitness solutions designed to help you succeed. Click on a service to learn more!
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div @click="showModal('Meal Planning', 'Our meal planning service provides customized nutrition plans tailored to your specific fitness goals and dietary preferences. Our expert coaches work with you to create balanced meal plans that include the right macronutrients (proteins, carbs, and fats) and micronutrients to fuel your workouts and support your recovery. Whether you\'re looking to lose weight, gain muscle, or maintain your current physique, we\'ll design a meal plan that fits your lifestyle and helps you achieve optimal results.', 'from-indigo-500 to-purple-600')" class="group cursor-pointer">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 h-full">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 w-16 h-16 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">Meal Planning</h3>
                        <p class="text-gray-600 mb-4">Customized nutrition plans based on your goals and preferences</p>
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-indigo-600 font-semibold text-sm">Learn More →</span>
                        </div>
                    </div>
                </div>
                
                <div @click="showModal('Workout Sessions', 'Our structured workout sessions are designed to match your current fitness level and help you progress safely and effectively. Each training program is customized to your goals, whether you want to build strength, improve cardiovascular health, increase flexibility, or enhance overall athletic performance. Our coaches provide detailed exercise instructions, proper form guidance, and progressive overload strategies to ensure you get the most out of every workout session.', 'from-green-500 to-teal-600')" class="group cursor-pointer">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 h-full">
                        <div class="bg-gradient-to-br from-green-500 to-teal-600 w-16 h-16 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">Workout Sessions</h3>
                        <p class="text-gray-600 mb-4">Structured training programs tailored to your fitness level</p>
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-indigo-600 font-semibold text-sm">Learn More →</span>
                        </div>
                    </div>
                </div>
                
                <div @click="showModal('Progress Tracking', 'Track your fitness journey with comprehensive progress monitoring. Our system allows you to record and monitor key metrics including weight, body fat percentage, and muscle mass over time. Visualize your progress with detailed analytics and charts that help you understand your body composition changes. Regular progress tracking helps you stay motivated, identify patterns, and make informed adjustments to your fitness and nutrition plans.', 'from-blue-500 to-cyan-600')" class="group cursor-pointer">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 h-full">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 w-16 h-16 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">Progress Tracking</h3>
                        <p class="text-gray-600 mb-4">Monitor weight, body fat, and muscle mass over time</p>
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-indigo-600 font-semibold text-sm">Learn More →</span>
                        </div>
                    </div>
                </div>
                
                <div @click="showModal('Coach Support', 'Get 24/7 access to your personal fitness coach who is dedicated to your success. Our coaches provide ongoing support, answer your questions, offer motivation, and help you stay on track with your fitness goals. Whether you need advice on form, nutrition tips, workout modifications, or just someone to keep you accountable, your coach is always there to guide you through your fitness journey.', 'from-pink-500 to-rose-600')" class="group cursor-pointer">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 h-full">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 w-16 h-16 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">Coach Support</h3>
                        <p class="text-gray-600 mb-4">24/7 access to your personal fitness coach</p>
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-indigo-600 font-semibold text-sm">Learn More →</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
function showModal(title, description, gradientClass) {
    if (window.showServiceModal) {
        window.showServiceModal(title, description, gradientClass);
    }
}
</script>

