<template>
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-slide-up">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">My Clients</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage and communicate with your clients</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <template v-if="clients && clients.length > 0">
                    <div v-for="client in clients" :key="client.id" class="bg-gradient-to-br from-white to-gray-50 border-2 border-gray-200 rounded-xl p-6 card-hover group hover:border-indigo-300 transition-all duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <span class="text-white font-bold text-xl">{{ getInitials(client.full_name) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ client.full_name }}</h3>
                                    <p class="text-xs text-gray-500">{{ client.email }}</p>
                                </div>
                            </div>
                            <span :class="`px-3 py-1.5 text-xs font-semibold rounded-full ${getStatusClass(client.status, 'client')}`">
                                {{ capitalize(client.status) }}
                            </span>
                        </div>
                        <div v-if="client.goal" class="mb-4 px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                            <p class="text-xs font-medium text-gray-500 mb-1">Goal</p>
                            <p class="text-sm font-semibold text-gray-900">{{ client.goal }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="showClientDetails(client.id)" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center px-4 py-2.5 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-semibold">
                                View Details
                            </button>
                            <button @click="openCoachChatPanel(client.id, client.full_name, client.email)" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-center px-4 py-2.5 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-semibold relative">
                                <span class="flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span>Chat</span>
                                </span>
                                <span v-if="client.unread_count && client.unread_count > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-md">{{ client.unread_count }}</span>
                            </button>
                        </div>
                    </div>
                </template>
                <div v-else class="col-span-full text-center py-12">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 font-semibold text-lg mb-2">No active clients assigned yet</p>
                        <p class="text-sm text-gray-500">Clients will appear here once they're assigned to you</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { getInitials, capitalize, getStatusClass } from '../utils.js';

const props = defineProps({
    clients: { type: Array, default: () => [] },
});

function showClientDetails(clientId) {
    if (window.showClientDetails) {
        window.showClientDetails(clientId);
    }
}

function openCoachChatPanel(clientId, clientName, clientEmail) {
    if (window.openCoachChatPanel) {
        window.openCoachChatPanel(clientId, clientName, clientEmail);
    }
}
</script>

