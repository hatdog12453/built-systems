<template>
    <section id="coaches" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-purple-50/30 to-transparent"></div>
        <div class="relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-4">Meet The Team</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Our Expert Coaches</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Meet our team of certified fitness professionals ready to guide you. Click on a coach to get started!
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <template v-if="coaches && coaches.length > 0">
                        <a v-for="coach in coaches" :key="coach.id" :href="getRegisterUrl(coach.id)" class="group">
                            <div class="bg-white p-6 rounded-lg shadow-md text-center border-2 border-transparent hover:border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer">
                                <div class="bg-indigo-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-700 group-hover:scale-110 transition-all duration-300">
                                    <span class="text-white text-2xl font-bold">{{ getInitials(coach.full_name) }}</span>
                                </div>
                                <h3 class="text-xl font-semibold mb-2 text-gray-900 group-hover:text-indigo-600 transition-colors">{{ coach.full_name }}</h3>
                                <p class="text-gray-600 mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ coach.clients_count }} {{ coach.clients_count == 1 ? 'Client' : 'Clients' }}
                                    </span>
                                </p>
                                <p v-if="coach.quotes" class="text-indigo-600 italic mt-3 group-hover:text-indigo-700 transition-colors">"{{ coach.quotes }}"</p>
                                <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-indigo-600 font-semibold text-sm">Select Coach →</span>
                                </div>
                            </div>
                        </a>
                    </template>
                    <div v-else class="col-span-3 text-center text-gray-600">
                        <p>No coaches available at the moment. Please check back later.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    coaches: { type: Array, default: () => [] },
    registerUrl: { type: String, default: '/register' },
});

function getInitials(name) {
    if (!name) return '';
    return name.substring(0, 1).toUpperCase();
}

function getRegisterUrl(coachId) {
    return `${props.registerUrl}/${coachId}`;
}
</script>

