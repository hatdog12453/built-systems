<template>
    <div
        v-if="isVisible"
        id="serviceModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 animate-fade-in"
        @click.self="closeModal"
    >
        <div class="relative top-10 md:top-20 mx-auto p-6 md:p-8 w-11/12 max-w-2xl shadow-2xl rounded-2xl bg-white animate-scale-in mb-10">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center space-x-4 flex-1">
                    <div
                        :class="`w-16 h-16 md:w-20 md:h-20 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg bg-gradient-to-br ${iconGradient}`"
                    >
                        <component :is="iconComponent" class="w-8 h-8 text-white" />
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Learn more about this service</p>
                    </div>
                </div>
                <button
                    @click="closeModal"
                    class="ml-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4 mb-6">
                <div class="bg-gradient-to-br from-gray-50 to-indigo-50 rounded-xl p-6 md:p-8 border border-gray-200">
                    <p class="text-gray-700 leading-relaxed text-base md:text-lg">{{ description }}</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200">
                <button
                    @click="closeModal"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200"
                >
                    Close
                </button>
                <a
                    :href="registerUrl"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 text-center"
                >
                    Get Started Now
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, h } from 'vue';

const props = defineProps({
    registerUrl: { type: String, default: '/register' },
});

const isVisible = ref(false);
const title = ref('');
const description = ref('');
const iconGradient = ref('from-indigo-500 to-purple-600');

const iconComponent = computed(() => {
    if (title.value === 'Meal Planning') {
        return () => h('svg', { class: 'w-8 h-8 text-white', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
            h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' })
        ]);
    } else if (title.value === 'Workout Sessions') {
        return () => h('svg', { class: 'w-8 h-8 text-white', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
            h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M13 10V3L4 14h7v7l9-11h-7z' })
        ]);
    } else if (title.value === 'Progress Tracking') {
        return () => h('svg', { class: 'w-8 h-8 text-white', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
            h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' })
        ]);
    } else if (title.value === 'Coach Support') {
        return () => h('svg', { class: 'w-8 h-8 text-white', fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
            h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' })
        ]);
    }
    return () => h('div');
});

function showModal(modalTitle, modalDescription, gradientClass) {
    title.value = modalTitle;
    description.value = modalDescription;
    iconGradient.value = gradientClass;
    isVisible.value = true;
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    isVisible.value = false;
    document.body.style.overflow = '';
}

function handleEscape(e) {
    if (e.key === 'Escape' && isVisible.value) {
        closeModal();
    }
}

onMounted(() => {
    window.showServiceModal = showModal;
    window.closeServiceModal = closeModal;
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    delete window.showServiceModal;
    delete window.closeServiceModal;
});
</script>

