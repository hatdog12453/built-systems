<template>
    <div class="lg:col-span-1 space-y-3">
        <!-- Meal Plans Button -->
        <button
            @click="switchTab('meal')"
            id="btn-meal-vue"
            :class="`w-full plan-nav-btn ${activeTab === 'meal' ? 'active ring-4 ring-offset-2 ring-white/50' : ''} bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-3`"
        >
            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    ></path>
                </svg>
            </div>
            <div class="text-left flex-1">
                <p class="font-bold text-sm">Meal Plans</p>
                <p class="text-xs text-white/80">{{ mealPlansCount }} plan(s)</p>
            </div>
        </button>

        <!-- Session Plans Button -->
        <button
            @click="switchTab('session')"
            id="btn-session-vue"
            :class="`w-full plan-nav-btn ${activeTab === 'session' ? 'active ring-4 ring-offset-2 ring-white/50' : ''} bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-3`"
        >
            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                </svg>
            </div>
            <div class="text-left flex-1">
                <p class="font-bold text-sm">Workout Plans</p>
                <p class="text-xs text-white/80">{{ sessionPlansCount }} plan(s)</p>
            </div>
        </button>

        <!-- Progress Trackers Button -->
        <button
            @click="switchTab('progress')"
            id="btn-progress-vue"
            :class="`w-full plan-nav-btn ${activeTab === 'progress' ? 'active ring-4 ring-offset-2 ring-white/50' : ''} bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-3`"
        >
            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                    ></path>
                </svg>
            </div>
            <div class="text-left flex-1">
                <p class="font-bold text-sm">Progress</p>
                <p class="text-xs text-white/80">{{ progressCount }} record(s)</p>
            </div>
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    mealPlansCount: { type: Number, required: true },
    sessionPlansCount: { type: Number, required: true },
    progressCount: { type: Number, required: true },
});

const activeTab = ref('meal');

function switchTab(tab) {
    activeTab.value = tab;
    // Emit custom event for ClientPlansContent to listen
    window.dispatchEvent(new CustomEvent('client-tab-change', { detail: { tab } }));
    // Also call the existing showPlans function for compatibility
    if (window.showPlans) {
        window.showPlans(tab);
    }
}

onMounted(() => {
    // Initialize - show meal plans by default
    switchTab('meal');
});
</script>
{
  "cells": [],
  "metadata": {
    "language_info": {
      "name": "python"
    }
  },
  "nbformat": 4,
  "nbformat_minor": 2
}
