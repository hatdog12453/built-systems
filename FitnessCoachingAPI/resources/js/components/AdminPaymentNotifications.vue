<template>
    <div v-if="payments && payments.length > 0" class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-6 mb-6 shadow-md animate-slide-in">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">New Payment Submissions (Last 24 Hours)</h3>
                <div class="space-y-2">
                    <div v-for="payment in payments" :key="payment.id" class="bg-white rounded-lg p-3 border border-blue-200">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">{{ payment.client.full_name }}</span> submitted a payment of 
                            <span class="font-semibold text-blue-600">₱{{ formatAmount(payment.amount) }}</span> via 
                            <span class="font-medium">{{ payment.method }}</span>
                            <span class="text-gray-500 text-xs ml-2">(Ref: {{ payment.transaction_reference_no }})</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { formatAmount } from '../utils.js';

const props = defineProps({
    payments: { type: Array, default: () => [] },
});
</script>

