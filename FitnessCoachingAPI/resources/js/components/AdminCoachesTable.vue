<template>
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden animate-slide-up">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Coaches</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Clients</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="coaches && coaches.length > 0">
                        <tr v-for="coach in coaches" :key="coach.id" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">{{ getInitials(coach.full_name) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ coach.full_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ coach.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ coach.clients_count }} {{ coach.clients_count == 1 ? 'Client' : 'Clients' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-3">
                                    <a :href="editUrl(coach.id)" class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" :action="deleteUrl(coach.id)" class="inline" :data-coach-id="coach.id">
                                        <input type="hidden" name="_token" :value="csrfToken" />
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="button" @click="handleDelete(coach.id)" class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="text-sm font-medium text-gray-500">No coaches found</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="paginationHtml" class="px-6 py-4 border-t border-gray-200" v-html="paginationHtml"></div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4 animate-fade-in"
        @click.self="cancelDelete"
    >
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in">
            <div class="p-6 md:p-8">
                <!-- Icon and Title -->
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Delete Coach</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Are you sure you want to delete this coach? This action cannot be undone.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <button
                        @click="cancelDelete"
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        @click="confirmDelete"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 hover:shadow-lg transition-all duration-200"
                    >
                        Delete Coach
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { getInitials } from '../utils.js';

const props = defineProps({
    coaches: { type: Array, default: () => [] },
    csrfToken: { type: String, required: true },
    editRoute: { type: String, default: '/admin/coaches' },
    deleteRoute: { type: String, default: '/admin/coaches' },
    paginationHtml: { type: String, default: '' },
});

const showDeleteModal = ref(false);
let pendingForm = null;
let pendingCoachId = null;

function editUrl(coachId) {
    return `${props.editRoute}/${coachId}/edit`;
}

function deleteUrl(coachId) {
    return `${props.deleteRoute}/${coachId}`;
}

function handleDelete(coachId) {
    // Find the form by coach ID
    const form = document.querySelector(`form[data-coach-id="${coachId}"]`);
    if (form) {
        pendingForm = form;
        pendingCoachId = coachId;
        showDeleteModal.value = true;
        document.body.style.overflow = 'hidden';
    }
}

function confirmDelete() {
    if (pendingForm) {
        showDeleteModal.value = false;
        document.body.style.overflow = '';
        pendingForm.submit();
        pendingForm = null;
        pendingCoachId = null;
    }
}

function cancelDelete() {
    showDeleteModal.value = false;
    document.body.style.overflow = '';
    pendingForm = null;
    pendingCoachId = null;
}

function handleEscape(e) {
    if (e.key === 'Escape' && showDeleteModal.value) {
        cancelDelete();
    }
}

onMounted(() => {
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    document.body.style.overflow = '';
});
</script>

