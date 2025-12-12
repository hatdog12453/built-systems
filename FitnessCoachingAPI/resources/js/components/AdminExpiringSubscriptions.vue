<template>
    <div v-if="clients && clients.length > 0" class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden animate-slide-up">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-orange-50 via-orange-100 to-orange-50 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Expiring Subscriptions (Next 7 Days)</h2>
            </div>
            <span class="px-4 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold shadow-md">{{ clients.length }} client(s)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Coach</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subscription Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Expires On</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Days Left</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="client in clients" :key="client.id" class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">{{ getInitials(client.full_name) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ client.full_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ client.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.coach.full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                {{ client.subscription_type ? capitalize(client.subscription_type) : 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ formatDate(client.subscription_expires_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="`px-3 py-1 inline-flex text-xs font-semibold rounded-full ${getDaysLeftClass(client.days_left)}`">
                                {{ client.days_left }} {{ client.days_left == 1 ? 'day' : 'days' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form method="POST" :action="sendReminderUrl(client.id)" class="inline">
                                <input type="hidden" name="_token" :value="csrfToken" />
                                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-xs font-semibold hover:shadow-md transform hover:scale-105 transition-all duration-200">
                                    Send Reminder
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { getInitials, capitalize, formatDate } from '../utils.js';

const props = defineProps({
    clients: { type: Array, default: () => [] },
    csrfToken: { type: String, required: true },
    sendReminderRoute: { type: String, default: '/admin/clients' },
});

function getDaysLeftClass(daysLeft) {
    return daysLeft <= 3 ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800';
}

function sendReminderUrl(clientId) {
    // Route format: /admin/clients/{id}/send-reminder
    return `/admin/clients/${clientId}/send-reminder`;
}
</script>

