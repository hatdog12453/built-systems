<template>
    <section id="programs" class="py-24 bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full text-sm font-semibold mb-4">Our Programs</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Fitness Programs</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choose from a variety of programs designed to help you reach your fitness goals
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="group bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Weight Loss</h3>
                    <p class="text-gray-600 mb-4">Structured programs focused on sustainable weight loss and healthy habits</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Custom meal plans</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Cardio workouts</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Progress tracking</li>
                    </ul>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Muscle Gain</h3>
                    <p class="text-gray-600 mb-4">Build lean muscle mass with targeted strength training and nutrition</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Strength training</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> High-protein meals</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Recovery plans</li>
                    </ul>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Endurance</h3>
                    <p class="text-gray-600 mb-4">Improve cardiovascular health and stamina with endurance training</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Cardio sessions</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Energy optimization</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Performance metrics</li>
                    </ul>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Flexibility</h3>
                    <p class="text-gray-600 mb-4">Enhance mobility and prevent injuries with flexibility training</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Stretching routines</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Yoga sessions</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Mobility work</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// Static content - no props needed
</script>

