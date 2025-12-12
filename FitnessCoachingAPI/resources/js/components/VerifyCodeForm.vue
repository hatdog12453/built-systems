<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Verify Code</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Enter the 6-digit verification code sent to your email</p>
                <p v-if="email" class="mt-1 text-center text-xs text-gray-500">{{ email }}</p>
            </div>
            <form class="mt-8 space-y-6" method="POST" :action="submitUrl" @submit.prevent="handleSubmit">
                <input type="hidden" name="_token" :value="csrfToken" />
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                        <input id="code" name="code" type="text" v-model="formData.code" maxlength="6" pattern="[0-9]{6}" required @input="handleCodeInput" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center text-2xl tracking-widest" placeholder="000000" autocomplete="off">
                        <p class="mt-1 text-xs text-gray-500">Enter the 6-digit code</p>
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
                        Verify
                    </button>
                </div>

                <div v-if="successMessage" class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ successMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600">Didn't receive the code?</p>
                    <a :href="forgotPasswordUrl" class="font-medium text-indigo-600 hover:text-indigo-500">Request a new code</a>
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
    forgotPasswordUrl: { type: String, default: '/forgot-password' },
    email: { type: String, default: '' },
    errorMessage: { type: String, default: '' },
    successMessage: { type: String, default: '' },
});

const formData = ref({
    code: '',
});

function handleCodeInput(event) {
    // Only allow numbers
    event.target.value = event.target.value.replace(/[^0-9]/g, '');
    formData.value.code = event.target.value;
}

function handleSubmit(event) {
    // Form will submit normally via POST
    event.target.submit();
}
</script>

