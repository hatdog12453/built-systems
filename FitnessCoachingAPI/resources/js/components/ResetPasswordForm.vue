<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Reset Password</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Enter your new password</p>
                <p v-if="email" class="mt-1 text-center text-xs text-gray-500">{{ email }}</p>
            </div>
            <form class="mt-8 space-y-6" method="POST" :action="submitUrl" @submit.prevent="handleSubmit">
                <input type="hidden" name="_token" :value="csrfToken" />
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" name="password" type="password" v-model="formData.password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter new password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" v-model="formData.password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Confirm new password">
                    </div>
                </div>

                <div v-if="errorMessage" class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ errorMessage }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset Password
                    </button>
                </div>

                <div class="text-center">
                    <a :href="loginUrl" class="font-medium text-indigo-600 hover:text-indigo-500">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    csrfToken: { type: String, required: true },
    submitUrl: { type: String, required: true },
    loginUrl: { type: String, default: '/login' },
    email: { type: String, default: '' },
    errorMessage: { type: String, default: '' },
});

const formData = ref({
    password: '',
    password_confirmation: '',
});

function handleSubmit(event) {
    // Form will submit normally via POST
    event.target.submit();
}
</script>

