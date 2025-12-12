<template>
    <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-bold mb-2">{{ activeClients }}</div>
            <div class="text-sm text-white/80">Active Clients</div>
        </div>
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-bold mb-2">{{ expertCoaches }}</div>
            <div class="text-sm text-white/80">Expert Coaches</div>
        </div>
        <div class="text-center">
            <div class="text-3xl md:text-4xl font-bold mb-2">{{ successRate }}</div>
            <div class="text-sm text-white/80">Success Rate</div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    activeClients: { type: String, required: true },
    expertCoaches: { type: String, required: true },
    successRate: { type: String, required: true },
});
</script>


