<template>
    <div class="p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-lg font-semibold text-gray-900">Data Inventaris</h1>
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative flex items-center">
                    <svg class="absolute left-3 w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input v-model="search" type="text" placeholder="Search Inventaris"
                        class="pl-9 pr-10 py-2 text-sm border border-gray-200 rounded-lg w-56 focus:outline-none focus:border-gray-400 text-gray-700 placeholder-gray-400" />
                    <button class="absolute right-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                            <line x1="11" y1="18" x2="13" y2="18" />
                        </svg>
                    </button>
                </div>

                <!-- Tambah Data -->
                <button @click="openAdd"
                    class="flex items-center cursor-pointer gap-2 bg-gray-900 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Table -->
        <!-- <pre>{{ data }}</pre> -->
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-16">No</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-36">Inventaris ID</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-40">Barang</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-28">Type</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-32">Serial Number</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-28">Spesifikasi</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-32">Status</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-28">Assign</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-32">Department</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-20">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in paginatedData" :key="item.id"
                    class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-4 text-sm text-gray-700">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                    <td class="py-4 text-sm text-gray-700">{{ item.inventaris_id }}</td>
                    <td class="py-4 text-sm text-gray-700">{{ item.barang }}</td>
                    <td class="py-4 text-sm text-gray-700">{{ item.type }}</td>
                    <td class="py-4 text-sm text-gray-700">{{ item.serial_number }}</td>
                    <td class="py-4 text-sm text-gray-700">{{ item.spesifikasi }}</td>
                    <td class="py-4">
                        <span :class="statusClass(item.status)"
                            class="inline-block px-2.5 py-1 text-xs font-medium rounded-md">
                            {{ item.status }}
                        </span>
                    </td>
                    <td class="py-4">
                        <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-md bg-teal-50 text-teal-700">
                            {{ item.user.name }}
                        </span>
                    </td>
                    <td class="py-4 text-sm text-gray-700">{{ item.department }}</td>
                    <td class="py-4">
                        <div class="relative">
                            <button @click.stop="toggleMenu(item.id)"
                                class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="5" cy="12" r="1.5" />
                                    <circle cx="12" cy="12" r="1.5" />
                                    <circle cx="19" cy="12" r="1.5" />
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div v-if="openMenuId === item.id" @click.stop
                                class="absolute right-0 mt-1 w-36 bg-white border border-gray-200 rounded-lg shadow-lg z-10 py-1">
                                <button @click="openEdit(item)"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</button>
                                <button @click="openDelete(item)"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Hapus</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Showing</span>
                <div class="relative">
                    <select v-model="itemsPerPage"
                        class="appearance-none border border-gray-200 rounded-lg pl-3 pr-7 py-1.5 text-sm text-gray-700 focus:outline-none focus:border-gray-400 cursor-pointer">
                        <option :value="5">5</option>
                        <option :value="10">10</option>
                        <option :value="15">15</option>
                        <option :value="20">20</option>
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-500 pointer-events-none"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>
                <span>items per page</span>
            </div>

            <div class="flex items-center gap-1 text-sm">
                <button @click="currentPage = Math.max(1, currentPage - 1)" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-gray-500 cursor-pointer hover:text-gray-900 disabled:opacity-40 disabled:cursor-not-allowed">
                    Previous
                </button>
                <button v-for="page in totalPages" :key="page" @click="currentPage = page"
                    :class="currentPage === page ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100'"
                    class="w-8 h-8 rounded-lg flex items-center justify-center font-medium transition-colors">
                    {{ page }}
                </button>
                <button @click="currentPage = Math.min(totalPages, currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1.5 text-gray-500 cursor-pointer hover:text-gray-900 disabled:opacity-40 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- ─── Modal Tambah ─── -->
    <Teleport to="body">
        <div v-if="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            @click.self="showAddModal = false">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Tambah Data</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Isi data inventaris baru di bawah ini</p>
                    </div>
                    <button @click="showAddModal = false"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors text-gray-500">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 mt-5">
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Inventaris ID</label>
                        <input v-model="addForm.inventaris_id" type="text" placeholder="Contoh: INV-1234"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Barang</label>
                        <input v-model="addForm.barang" type="text" placeholder="Nama barang"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Type</label>
                        <input v-model="addForm.type" type="text" placeholder="Contoh: Laptop"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Serial Number</label>
                        <input v-model="addForm.serial_number" type="text" placeholder="Nomor seri"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Spesifikasi</label>
                        <input v-model="addForm.spesifikasi" type="text" placeholder="Contoh: RAM 12"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Status</label>
                        <div class="relative">
                            <select v-model="addForm.status"
                                class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                <option value="" disabled>Pilih status</option>
                                <option v-for="s in statusOptions" :key="s" :value="s">{{ s }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-gray-600 mb-1 block">Assign</label>
                            <div class="relative">
                                <select v-model="addForm.user_id"
                                    class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                    <option value="" disabled>Pilih user</option>
                                    <option v-for="u in assignOptions" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600 mb-1 block">Department</label>
                            <div class="relative">
                                <select v-model="addForm.department"
                                    class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                    <option value="" disabled>Pilih</option>
                                    <option v-for="d in departmentOptions" :key="d" :value="d">{{ d }}</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button @click="showAddModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button @click="confirmAdd(addForm); showAddModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </Teleport>

    <!-- ─── Modal Edit ─── -->
    <Teleport to="body">
        <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            @click.self="showEditModal = false">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Edit Data</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Make sure everything looks right before saving.</p>
                    </div>
                    <button @click="showEditModal = false"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors text-gray-500">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 mt-5">
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Inventaris ID</label>
                        <input v-model="editForm.inventaris_id" type="text"
                            class="w-full border border-teal-200 bg-teal-50/30 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Barang</label>
                        <input v-model="editForm.barang" type="text"
                            class="w-full border border-teal-200 bg-teal-50/30 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Type</label>
                        <input v-model="editForm.type" type="text"
                            class="w-full border border-teal-200 bg-teal-50/30 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Serial Number</label>
                        <input v-model="editForm.serial_number" type="text"
                            class="w-full border border-teal-200 bg-teal-50/30 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Spesifikasi</label>
                        <input v-model="editForm.spesifikasi" type="text"
                            class="w-full border border-teal-200 bg-teal-50/30 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400" />
                    </div>
                    <div>
                        <label class="text-xs font-medium text-teal-600 mb-1 block">Status</label>
                        <div class="relative">
                            <select v-model="editForm.status"
                                class="w-full appearance-none border border-teal-200 bg-teal-50/30 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400 cursor-pointer">
                                <option v-for="s in statusOptions" :key="s" :value="s">{{ s }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-teal-600 mb-1 block">Assign</label>
                            <div class="relative">
                                <select v-model="editForm.user.name"
                                    class="w-full appearance-none border border-teal-200 bg-teal-50/30 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400 cursor-pointer">
                                    <option v-for="u in assignOptions" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-teal-600 mb-1 block">Department</label>
                            <div class="relative">
                                <select v-model="editForm.department"
                                    class="w-full appearance-none border border-teal-200 bg-teal-50/30 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-teal-400 cursor-pointer">
                                    <option v-for="d in departmentOptions" :key="d" :value="d">{{ d }}</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button @click="showEditModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button @click="confirmUpdate(editForm, editForm.id); showEditModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </Teleport>

    <!-- ─── Modal Hapus ─── -->
    <Teleport to="body">
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            @click.self="showDeleteModal = false">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                    </svg>
                </div>
                <h2 class="text-base font-semibold text-gray-900 mb-1">Hapus Inventaris</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Apakah kamu yakin ingin menghapus
                    <span class="font-medium text-gray-800">{{ selectedItem?.inventaris_id }}</span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-2">
                    <button @click="showDeleteModal = false"
                        class="flex-1 px-4 py-2 text-sm text-gray-600 border cursor-pointer border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button @click="confirmDelete(selectedItem?.id); showDeleteModal = false"
                        class="flex-1 px-4 py-2 text-sm text-white bg-red-500 cursor-pointer rounded-lg hover:bg-red-600 transition-colors font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'
import { useInventoryStore } from '@/stores/inventory'
import type { Inventaris } from '@/types'
import { storeToRefs } from 'pinia'
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

const userData = storeToRefs(useAuthStore())

const statusOptions = ['Baik', 'Rusak', 'Tidak Dipakai', 'Dilelang']
const departmentOptions = ['Technology', 'Marketing', 'Finance']
const assignOptions = computed(() => {
    if (!Array.isArray(userData.data.value)) return []
    return userData.data.value.map(u => ({id: u.id, name: u.name}))
})

const statusClass = (status: string) => {
    switch (status) {
        case 'Baik': return 'bg-green-100 text-green-700'
        case 'Rusak': return 'bg-red-100 text-red-600'
        case 'Tidak Dipakai': return 'bg-gray-100 text-gray-600'
        case 'Dilelang': return 'bg-orange-100 text-orange-600'
        default: return 'bg-gray-100 text-gray-600'
    }
}

const search = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)
const openMenuId = ref<number | null>(null)

const showAddModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedItem = ref<Inventaris | null>(null)

const { getAllData, confirmAdd, confirmDelete, confirmUpdate } = useInventoryStore()
const { data } = storeToRefs(useInventoryStore())

const emptyForm = () => ({
    inventaris_id: '', barang: '', type: '', serial_number: '',
    spesifikasi: '', status: '', user_id: null, department: '', user: null
})

const addForm = ref(emptyForm())
const editForm = ref({ ...emptyForm(), id: 0 })

// const allData = ref<Inventaris[]>([
//     { id: 1, inventarisId: 'INV-1234', barang: 'Lenovo Legion', type: 'Laptop', serialNumber: '123456', spesifikasi: 'RAM 12', status: 'Baik', assign: 'userA', department: 'Technology' },
//     { id: 2, inventarisId: 'INV-1235', barang: 'Lenovo Legion', type: 'Laptop', serialNumber: '123456', spesifikasi: 'RAM 12', status: 'Rusak', assign: 'userB', department: 'Technology' },
//     { id: 3, inventarisId: 'INV-1236', barang: 'Lenovo Legion', type: 'Laptop', serialNumber: '123456', spesifikasi: 'RAM 12', status: 'Tidak Dipakai', assign: 'userC', department: 'Technology' },
//     { id: 4, inventarisId: 'INV-1237', barang: 'Lenovo Legion', type: 'Laptop', serialNumber: '123456', spesifikasi: 'RAM 12', status: 'Dilelang', assign: 'userD', department: 'Technology' },
//     { id: 5, inventarisId: 'INV-1238', barang: 'Lenovo Legion', type: 'Laptop', serialNumber: '123456', spesifikasi: 'RAM 12', status: 'Dilelang', assign: 'userE', department: 'Technology' },
//     { id: 6, inventarisId: 'INV-1239', barang: 'MacBook Pro', type: 'Laptop', serialNumber: '789012', spesifikasi: 'RAM 16', status: 'Baik', assign: 'userA', department: 'Design' },
//     { id: 7, inventarisId: 'INV-1240', barang: 'Dell Monitor', type: 'Monitor', serialNumber: '345678', spesifikasi: '27 inch', status: 'Baik', assign: 'userB', department: 'Marketing' },
//     { id: 8, inventarisId: 'INV-1241', barang: 'HP Printer', type: 'Printer', serialNumber: '901234', spesifikasi: 'Color', status: 'Rusak', assign: 'userC', department: 'Finance' },
//     { id: 9, inventarisId: 'INV-1242', barang: 'Logitech Mouse', type: 'Peripheral', serialNumber: '567890', spesifikasi: 'Wireless', status: 'Baik', assign: 'userD', department: 'Technology' },
//     { id: 10, inventarisId: 'INV-1243', barang: 'Mechanical Keyboard', type: 'Peripheral', serialNumber: '123789', spesifikasi: 'TKL', status: 'Tidak Dipakai', assign: 'userE', department: 'Technology' },
//     { id: 11, inventarisId: 'INV-1244', barang: 'iPad Pro', type: 'Tablet', serialNumber: '456123', spesifikasi: '256GB', status: 'Baik', assign: 'userA', department: 'Design' },
//     { id: 12, inventarisId: 'INV-1245', barang: 'Cisco Switch', type: 'Network', serialNumber: '789456', spesifikasi: '24 Port', status: 'Baik', assign: 'userB', department: 'Technology' },
//     { id: 13, inventarisId: 'INV-1246', barang: 'Projector Epson', type: 'Projector', serialNumber: '321654', spesifikasi: 'Full HD', status: 'Dilelang', assign: 'userC', department: 'HR' },
//     { id: 14, inventarisId: 'INV-1247', barang: 'UPS APC', type: 'UPS', serialNumber: '654987', spesifikasi: '1500VA', status: 'Baik', assign: 'userD', department: 'Finance' },
//     { id: 15, inventarisId: 'INV-1248', barang: 'Server Dell', type: 'Server', serialNumber: '987321', spesifikasi: '32GB RAM', status: 'Baik', assign: 'userE', department: 'Technology' },
// ])

const filteredData = computed(() => {
    if (!Array.isArray(data.value)) return []
    return data.value.filter(d =>
        (d.inventaris_id ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (d.barang ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (d.type ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (d.department ?? '').toLowerCase().includes(search.value.toLowerCase())
    )
})

const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage.value))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    return filteredData.value.slice(start, start + itemsPerPage.value)
})

watch([itemsPerPage, search], () => { currentPage.value = 1 })

const toggleMenu = (id: number) => {
    openMenuId.value = openMenuId.value === id ? null : id
}
const closeMenu = () => { openMenuId.value = null }
onMounted(() => {
    document.addEventListener('click', closeMenu)
    getAllData()
})
onUnmounted(() => document.removeEventListener('click', closeMenu))

// ── Tambah ──
const openAdd = () => {
    addForm.value = emptyForm()
    showAddModal.value = true
}
// const saveAdd = () => {
//     if (!addForm.value.inventaris_id || !addForm.value.barang) return
//     const newId = Math.max(...data?.value.map(d => d.id)) + 1
//     data?.value.push({ id: newId, ...addForm.value })
//     showAddModal.value = false
// }

// ── Edit ──
const openEdit = (item: Inventaris) => {
    selectedItem.value = item
    editForm.value = { ...item }
    openMenuId.value = null
    showEditModal.value = true
}
// const saveEdit = () => {
//     const target = data?.value.find(d => d.id === editForm.value.id)
//     if (target) Object.assign(target, editForm.value)
//     showEditModal.value = false
// }

// ── Hapus ──
const openDelete = (item: Inventaris) => {
    selectedItem.value = item
    openMenuId.value = null
    showDeleteModal.value = true
}
// const handleDelete = () => {
//     data.value = data?.value.filter(d => d.id !== selectedItem.value?.id)
//     showDeleteModal.value = false
// }
</script>