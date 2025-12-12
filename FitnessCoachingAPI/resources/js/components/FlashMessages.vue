<template>
    <div
        v-if="hasMessages"
        id="flash-messages"
        class="fixed top-24 right-4 z-50 space-y-2 max-w-md"
    >
        <div
            v-if="successMessage"
            class="bg-white rounded-xl shadow-xl border-l-4 border-green-500 p-4 animate-slide-in flex items-start space-x-3"
        >
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Success</p>
                <p class="text-sm text-gray-600 mt-1">{{ successMessage }}</p>
            </div>
            <button @click="successMessage = null" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div
            v-if="errorMessage"
            class="bg-white rounded-xl shadow-xl border-l-4 border-red-500 p-4 animate-slide-in flex items-start space-x-3"
        >
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Error</p>
                <p class="text-sm text-gray-600 mt-1">{{ errorMessage }}</p>
            </div>
            <button @click="errorMessage = null" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    success: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
    autoHideAfterMs: {
        type: Number,
        default: 5000,
    },
});

const successMessage = ref(props.success || null);
const errorMessage = ref(props.error || null);

const hasMessages = computed(() => !!successMessage.value || !!errorMessage.value);

onMounted(() => {
    if (!props.autoHideAfterMs || props.autoHideAfterMs <= 0) {
        return;
    }

    if (successMessage.value) {
        setTimeout(() => {
            successMessage.value = null;
        }, props.autoHideAfterMs);
    }

    if (errorMessage.value) {
        setTimeout(() => {
            errorMessage.value = null;
        }, props.autoHideAfterMs);
    }
});
</script>


