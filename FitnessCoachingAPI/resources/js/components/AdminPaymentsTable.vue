<template>
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden animate-slide-up">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Payments</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="payments && payments.length > 0">
                        <tr v-for="payment in payments" :key="payment.id" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">{{ getInitials(payment.client.full_name) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ payment.client.full_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">₱{{ formatAmount(payment.amount) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ payment.payment_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ formatMethod(payment.method) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="`px-3 py-1 inline-flex text-xs font-semibold rounded-full ${getStatusClass(payment.status, 'payment')}`">
                                    {{ capitalize(payment.status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form method="POST" :action="updateStatusUrl(payment.id)" class="inline" @submit.prevent="handleSubmit">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <select name="status" :value="payment.status" @change="handleChange" class="text-sm border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="failed">Failed</option>
                                        <option value="refunded">Refunded</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-medium text-gray-500">No payments found</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="paginationHtml" class="px-6 py-4 border-t border-gray-200" v-html="paginationHtml"></div>
    </div>
</template>

<script setup>
import { getInitials, formatAmount, formatMethod, capitalize, getStatusClass } from '../utils.js';

const props = defineProps({
    payments: { type: Array, default: () => [] },
    csrfToken: { type: String, required: true },
    updateStatusRoute: { type: String, default: '/admin/payments' },
    paginationHtml: { type: String, default: '' },
});

function updateStatusUrl(paymentId) {
    return `${props.updateStatusRoute}/${paymentId}/status`;
}

function handleChange(event) {
    const form = event.target.closest('form');
    if (form) {
        form.submit();
    }
}

function handleSubmit(event) {
    // Form will submit normally via POST
}
</script>

