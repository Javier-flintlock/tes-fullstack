<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <form class="w-full max-w-sm" @submit.prevent="login(form)">

            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <div
                    class="w-9 h-9 rounded-full bg-gray-800 flex items-center justify-center text-white text-sm font-semibold">
                    m
                </div>
                <div class="leading-tight">
                    <div class="text-xs font-medium text-gray-500">managemen</div>
                    <div class="text-sm font-bold text-gray-900">inventaris.</div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">

                <!-- Header -->
                <div class="mb-7">
                    <h1 class="text-xl font-bold text-gray-900 mb-1">Selamat datang</h1>
                    <p class="text-sm text-gray-500">Masuk untuk melanjutkan ke dashboard</p>
                </div>

                <!-- Form -->
                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1.5 block">Email</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                                <path d="M2 7l10 7 10-7" />
                            </svg>
                            <input v-model="form.email" type="email" placeholder="nama@email.com"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-gray-400 text-gray-800 placeholder-gray-300 transition-colors" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1.5 block">Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                placeholder="Masukkan password"
                                class="w-full pl-9 pr-10 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-gray-400 text-gray-800 placeholder-gray-300 transition-colors" />
                            <button @click="showPassword = !showPassword" type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <!-- Eye open -->
                                <svg v-if="!showPassword" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <!-- Eye closed -->
                                <svg v-else class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button
                    class="w-full mt-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    Masuk
                </button>

            </div>

        </form>
    </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';
import { ref } from 'vue'

const form = ref({
    email: '',
    password: ''
})

const {login} = useAuthStore()
const showPassword = ref(false)
</script>