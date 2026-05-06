<template>
    <div class="p-8">
        <h1 class="text-lg font-semibold text-gray-900 mb-6">Analytics</h1>

        <!-- Stat Cards -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <!-- Barang Baik -->
            <div class="bg-gray-100 rounded-2xl p-5">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <button class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:text-gray-600 text-xs font-medium">
                        i
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-1">Barang Baik</p>
                <p class="text-3xl font-semibold text-gray-900">{{ stats.baik }}</p>
            </div>

            <!-- Barang Rusak -->
            <div class="bg-gray-100 rounded-2xl p-5">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <button class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:text-gray-600 text-xs font-medium">
                        i
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-1">Barang Rusak</p>
                <p class="text-3xl font-semibold text-gray-900">{{ stats.rusak }}</p>
            </div>

            <!-- Dilelang -->
            <div class="bg-gray-100 rounded-2xl p-5">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                    </div>
                    <button class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:text-gray-600 text-xs font-medium">
                        i
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-1">Dilelang</p>
                <p class="text-3xl font-semibold text-gray-900">{{ stats.dilelang }}</p>
            </div>

            <!-- Tidak Dipakai -->
            <div class="bg-gray-100 rounded-2xl p-5">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                    </div>
                    <button class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:text-gray-600 text-xs font-medium">
                        i
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-1">Tidak Dipakai</p>
                <p class="text-3xl font-semibold text-gray-900">{{ stats.tidakDipakai }}</p>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 px-6 pt-6 pb-4">
            <!-- Y-axis labels + bars -->
            <div class="flex gap-4">
                <!-- Y axis -->
                <div class="flex flex-col justify-between text-xs text-gray-400 text-right pr-2 pb-8" style="min-width: 32px; height: 320px;">
                    <span>{{ yMax }}</span>
                    <span>{{ Math.round(yMax * 0.8) }}</span>
                    <span>{{ Math.round(yMax * 0.6) }}</span>
                    <span>{{ Math.round(yMax * 0.4) }}</span>
                    <span>{{ Math.round(yMax * 0.2) }}</span>
                    <span>0</span>
                </div>

                <!-- Chart area -->
                <div class="flex-1 relative" style="height: 320px;">
                    <!-- Grid lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pb-8">
                        <div v-for="i in 6" :key="i" class="border-t border-dashed border-gray-200 w-full"></div>
                    </div>

                    <!-- Bars -->
                    <div class="absolute inset-0 flex items-end justify-around pb-8 gap-6 px-8">
                        <div v-for="bar in chartData" :key="bar.label"
                            class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full rounded-t-xl transition-all duration-500"
                                :style="{
                                    height: `${(bar.value / yMax) * 260}px`,
                                    backgroundColor: '#7C3AED'
                                }">
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ bar.label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useInventoryStore } from '@/stores/inventory'
import { storeToRefs } from 'pinia'
import { computed } from 'vue'

const { data } = storeToRefs(useInventoryStore())

const stats = computed(() => {
    if (!Array.isArray(data.value)) return { baik: 0, rusak: 0, dilelang: 0, tidakDipakai: 0 }
    return {
        baik: data.value.filter(d => d.status === 'Baik').length,
        rusak: data.value.filter(d => d.status === 'Rusak').length,
        dilelang: data.value.filter(d => d.status === 'Dilelang').length,
        tidakDipakai: data.value.filter(d => d.status === 'Tidak Dipakai').length,
    }
})

const chartData = computed(() => [
    { label: 'Barang Baik', value: stats.value.baik },
    { label: 'Barang Rusak', value: stats.value.rusak },
    { label: 'Dilelang', value: stats.value.dilelang },
    { label: 'Tidak Dipakai', value: stats.value.tidakDipakai },
])

const yMax = computed(() => {
    const max = Math.max(...chartData.value.map(d => d.value), 10)
    return Math.ceil(max / 10) * 10
})
</script>