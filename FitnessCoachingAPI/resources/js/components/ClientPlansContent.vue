<template>
    <div class="lg:col-span-3">
        <!-- Meal Plans Content -->
        <div id="content-meal" :class="`plan-content max-h-[600px] overflow-y-auto pr-2 custom-scrollbar ${activeTab !== 'meal' ? 'hidden' : ''}`">
            <template v-if="mealPlans && mealPlans.length > 0">
                <div class="space-y-4">
                    <div v-for="(mealPlan, index) in mealPlans" :key="mealPlan.id" class="bg-gradient-to-br from-orange-50 via-orange-100 to-orange-50 rounded-2xl shadow-xl border-2 border-orange-200 overflow-hidden card-hover group animate-slide-up">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">Meal Plan #{{ mealPlans.length - index }}</h3>
                                        <p class="text-xs text-white/90">{{ formatDate(mealPlan.created_at) }}</p>
                                    </div>
                                </div>
                                <span v-if="mealPlan.meal_type" class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-semibold text-white capitalize">
                                    {{ formatMealType(mealPlan.meal_type) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Macros Grid -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div class="bg-white rounded-xl p-4 border border-green-200 text-center group-hover:shadow-md transition-shadow">
                                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Protein</p>
                                        <p class="text-2xl font-extrabold text-green-600">{{ mealPlan.protein }}g</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-yellow-200 text-center group-hover:shadow-md transition-shadow">
                                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Carbs</p>
                                        <p class="text-2xl font-extrabold text-yellow-600">{{ mealPlan.carbs }}g</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-purple-200 text-center group-hover:shadow-md transition-shadow">
                                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Fats</p>
                                        <p class="text-2xl font-extrabold text-purple-600">{{ mealPlan.fats }}g</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-blue-200 text-center group-hover:shadow-md transition-shadow">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Calories</p>
                                        <p class="text-2xl font-extrabold text-blue-600">{{ mealPlan.calories || 'N/A' }}</p>
                                    </div>
                                </div>

                                <div v-if="mealPlan.description" class="bg-white rounded-xl p-4 border border-orange-200">
                                    <p class="text-xs font-semibold text-gray-500 mb-2">Description</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ mealPlan.description }}</p>
                                </div>

                                <div v-if="mealPlan.notes" class="bg-white rounded-xl p-4 border-l-4 border-indigo-500">
                                    <p class="text-xs font-semibold text-indigo-600 mb-1">Coach Notes</p>
                                    <p class="text-sm text-gray-700">{{ mealPlan.notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="bg-gradient-to-br from-orange-50 via-orange-100 to-orange-50 rounded-2xl shadow-xl border-2 border-orange-200 p-12 text-center">
                <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold text-lg mb-2">No meal plans yet</p>
                <p class="text-sm text-gray-600">Your coach will assign meal plans soon</p>
            </div>
        </div>

        <!-- Session Plans Content -->
        <div id="content-session" :class="`plan-content max-h-[600px] overflow-y-auto pr-2 custom-scrollbar ${activeTab !== 'session' ? 'hidden' : ''}`">
            <template v-if="sessionPlans && sessionPlans.length > 0">
                <div class="space-y-4">
                    <div v-for="(sessionPlan, index) in sessionPlans" :key="sessionPlan.id" class="bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 rounded-2xl shadow-xl border-2 border-purple-200 overflow-hidden card-hover group animate-slide-up">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">Workout Plan #{{ sessionPlans.length - index }}</h3>
                                        <p class="text-xs text-white/90">{{ formatDate(sessionPlan.created_at) }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-semibold text-white">
                                    {{ sessionPlan.type_of_workout }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="bg-white rounded-xl p-4 border border-purple-200">
                                    <p class="text-xs font-semibold text-gray-500 mb-1">Workout Type</p>
                                    <p class="text-lg font-bold text-gray-900">{{ sessionPlan.type_of_workout }}</p>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <div class="bg-white rounded-xl p-4 border border-blue-200 text-center">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Duration</p>
                                        <p class="text-xl font-extrabold text-blue-600">{{ sessionPlan.duration }}m</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-indigo-200 text-center">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Status</p>
                                        <span :class="`px-2 py-1 inline-flex text-xs font-bold rounded-full ${getStatusClass(sessionPlan.status, 'session')}`">
                                            {{ formatStatus(sessionPlan.status) }}
                                        </span>
                                    </div>
                                    <div v-if="sessionPlan.target_muscle" class="bg-white rounded-xl p-4 border border-green-200 text-center">
                                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Target</p>
                                        <p class="text-sm font-bold text-green-600">{{ sessionPlan.target_muscle }}</p>
                                    </div>
                                </div>

                                <div v-if="sessionPlan.description" class="bg-white rounded-xl p-4 border border-purple-200">
                                    <p class="text-xs font-semibold text-gray-500 mb-2">Description</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ sessionPlan.description }}</p>
                                </div>

                                <div v-if="sessionPlan.date" class="bg-white rounded-xl p-4 border-l-4 border-indigo-500">
                                    <p class="text-xs font-semibold text-gray-500 mb-1">Scheduled Date</p>
                                    <p class="text-sm font-bold text-gray-900">{{ sessionPlan.date }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 rounded-2xl shadow-xl border-2 border-purple-200 p-12 text-center">
                <div class="w-20 h-20 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold text-lg mb-2">No workout plans yet</p>
                <p class="text-sm text-gray-600">Your coach will assign workout plans soon</p>
            </div>
        </div>

        <!-- Progress Trackers Content -->
        <div id="content-progress" :class="`plan-content max-h-[600px] overflow-y-auto pr-2 custom-scrollbar ${activeTab !== 'progress' ? 'hidden' : ''}`">
            <template v-if="progressTrackers && progressTrackers.length > 0">
                <div class="space-y-4">
                    <div v-for="(progressTracker, index) in progressTrackers" :key="progressTracker.id" class="bg-gradient-to-br from-green-50 via-green-100 to-green-50 rounded-2xl shadow-xl border-2 border-green-200 overflow-hidden card-hover group animate-slide-up">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">Progress Record #{{ progressTrackers.length - index }}</h3>
                                        <p class="text-xs text-white/90">{{ formatDate(progressTracker.record_at || progressTracker.created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="bg-white rounded-xl p-5 border border-blue-200 text-center">
                                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 mb-1">Weight Progress</p>
                                    <p class="text-3xl font-extrabold text-blue-600">{{ progressTracker.weight_progress || 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">kilograms</p>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-white rounded-xl p-4 border border-orange-200 text-center">
                                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Body Fat</p>
                                        <p class="text-xl font-extrabold text-orange-600">{{ progressTracker.body_fat_percentage || 'N/A' }}%</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-green-200 text-center">
                                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Muscle Mass</p>
                                        <p class="text-xl font-extrabold text-green-600">{{ progressTracker.muscle_mass || 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">kg</p>
                                    </div>
                                </div>

                                <div v-if="progressTracker.remarks" class="bg-white rounded-xl p-4 border border-indigo-200">
                                    <p class="text-xs font-semibold text-indigo-600 mb-1">Coach Remarks</p>
                                    <p class="text-sm text-gray-700">{{ progressTracker.remarks }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="bg-gradient-to-br from-green-50 via-green-100 to-green-50 rounded-2xl shadow-xl border-2 border-green-200 p-12 text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold text-lg mb-2">No progress records yet</p>
                <p class="text-sm text-gray-600">Your coach will add progress records soon</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { formatDate, formatMealType, formatStatus, getStatusClass } from '../utils.js';

const props = defineProps({
    mealPlans: { type: Array, default: () => [] },
    sessionPlans: { type: Array, default: () => [] },
    progressTrackers: { type: Array, default: () => [] },
});

const activeTab = ref('meal');

onMounted(() => {
    // Listen for tab changes from the side navigation buttons
    const handleTabChange = (event) => {
        const tab = event.detail?.tab;
        if (tab) {
            activeTab.value = tab;
        }
    };
    
    window.addEventListener('client-tab-change', handleTabChange);
    
    // Cleanup
    return () => {
        window.removeEventListener('client-tab-change', handleTabChange);
    };
});
</script>

