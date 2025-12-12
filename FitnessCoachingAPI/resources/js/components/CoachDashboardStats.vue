<template>
    <div class="lg:col-span-1 space-y-3">
        <button
            onclick="scrollToSection('clients')"
            class="w-full stats-nav-btn bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex flex-col items-center space-y-2"
        >
            <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">Total Clients</p>
                <p class="text-2xl font-extrabold">{{ totalClients }}</p>
            </div>
        </button>

        <button
            onclick="scrollToSection('clients')"
            class="w-full stats-nav-btn bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex flex-col items-center space-y-2"
        >
            <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">Active Clients</p>
                <p class="text-2xl font-extrabold">{{ activeClients }}</p>
            </div>
        </button>

        <button
            onclick="scrollToSection('meal-plans')"
            class="w-full stats-nav-btn bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex flex-col items-center space-y-2"
        >
            <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    ></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">Meal Plans</p>
                <p class="text-2xl font-extrabold">{{ totalMealPlans }}</p>
            </div>
        </button>

        <button
            onclick="scrollToSection('session-plans')"
            class="w-full stats-nav-btn bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-4 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex flex-col items-center space-y-2"
        >
            <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">Session Plans</p>
                <p class="text-2xl font-extrabold">{{ totalSessionPlans }}</p>
            </div>
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    totalClients: { type: Number, required: true },
    activeClients: { type: Number, required: true },
    totalMealPlans: { type: Number, required: true },
    totalSessionPlans: { type: Number, required: true },
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