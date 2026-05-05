<template>
    <aside class="w-64 flex flex-col border-r border-gray-200 bg-white shrink-0 h-screen">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-6">
            <div
                class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white text-sm font-semibold">
                m
            </div>
            <div class="leading-tight">
                <div class="text-xs text-gray-500 font-medium">managemen</div>
                <div class="text-sm font-bold text-gray-900 font-bold">inventaris.</div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 space-y-1">
            <RouterLink to="/data-inventaris"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors"
                active-class="bg-gray-100 text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Data Inventaris
                </div>
                <span class="w-1.5 h-4 rounded-full bg-gray-900 block ml-auto"
                    v-show="isActive('/data-inventaris')"></span>
            </RouterLink>

            <RouterLink to="/management-anggota"
                class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors"
                active-class="bg-gray-100 text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="3" />
                        <path d="M6 20v-1a6 6 0 0 1 12 0v1" />
                    </svg>
                    Management Anggota
                </div>
                <span class="w-1.5 h-4 rounded-full bg-gray-900 block" v-show="isActive('/management-anggota')"></span>
            </RouterLink>

            <RouterLink to="/analytics"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors"
                active-class="bg-gray-100 text-gray-900 font-medium">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                <div class="flex items-center gap-3">
                    Analytics
                </div>
                <span class="w-1.5 h-4 rounded-full bg-gray-900 block ml-auto"
                    v-show="isActive('/analytics')"></span>
            </RouterLink>
        </nav>

        <!-- User Profile -->
        <div class="mx-3 mb-4 p-3 rounded-xl bg-gray-50 border border-gray-200">
            <div class="flex items-center gap-3 mb-3">
                <img src="https://api.dicebear.com/7.x/notionists/svg?seed=tiara"
                    class="w-9 h-9 rounded-full bg-orange-200" alt="avatar" />
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-gray-900">tiara tiara</div>
                    <div class="text-xs text-gray-500">tiara@botika.online</div>
                </div>
            </div>

            <!-- Dark Theme Toggle -->
            <div class="flex items-center justify-between text-sm text-gray-600 py-1.5">
                <label class="flex items-center gap-2" for="dark-mode">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                    </svg>
                    Dark Theme
                </label>
                <button @click="isDark = !isDark" :class="isDark ? 'bg-gray-900' : 'bg-gray-300'"
                    class="relative w-9 h-5 rounded-full transition-colors duration-200 cursor-pointer" id="dark-mode">
                    <span :class="isDark ? '-translate-x-4' : 'translate-x-0.5'"
                        class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></span>
                </button>
            </div>

            <!-- Logout -->
            <button
                class="flex items-center cursor-pointer gap-2 text-sm text-gray-600 py-1.5 hover:text-gray-900 transition-colors w-full">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Logout
            </button>
        </div>
    </aside>
</template>

<script setup lang="ts">
import router from '@/router';
import { ref } from 'vue'

const isDark = ref(false)
const isActive = (path: string) => router.currentRoute.value.path === path
</script>