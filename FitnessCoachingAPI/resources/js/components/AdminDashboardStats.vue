<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        <!-- Total Clients -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full -mr-16 -mt-16 opacity-20"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg"
                    >
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Total Clients</h3>
                <p class="text-4xl font-extrabold text-gray-900">{{ totalClients }}</p>
            </div>
        </div>

        <!-- Total Coaches -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-100 rounded-full -mr-16 -mt-16 opacity-20"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg"
                    >
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Total Coaches</h3>
                <p class="text-4xl font-extrabold text-gray-900">{{ totalCoaches }}</p>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full -mr-16 -mt-16 opacity-20"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg"
                    >
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Pending Payments</h3>
                <p class="text-4xl font-extrabold text-yellow-600">{{ pendingPayments }}</p>
            </div>
        </div>

        <!-- Active Clients -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-100 rounded-full -mr-16 -mt-16 opacity-20"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg"
                    >
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Active Clients</h3>
                <p class="text-4xl font-extrabold text-green-600">{{ activeClients }}</p>
            </div>
        </div>

        <!-- Expiring Subscriptions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-100 rounded-full -mr-16 -mt-16 opacity-20"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg"
                    >
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Expiring Subscriptions</h3>
                <p class="text-4xl font-extrabold text-orange-600">{{ expiringSubscriptions }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    totalClients: { type: Number, required: true },
    totalCoaches: { type: Number, required: true },
    pendingPayments: { type: Number, required: true },
    activeClients: { type: Number, required: true },
    expiringSubscriptions: { type: Number, required: true },
});
</script>


