<template>
    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
        <p class="text-sm text-blue-800">
            <strong>Client:</strong> {{ clientName }}<br />
            <strong>Email:</strong> {{ clientEmail }}<br />
            <strong>Subscription:</strong> {{ subscription || 'Not selected' }}
        </p>
    </div>
</template>

<script setup>
const props = defineProps({
    clientName: { type: String, required: true },
    clientEmail: { type: String, required: true },
    subscription: { type: String, default: '' },
});
</script>


