<template>
    <div class="p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-lg font-semibold text-gray-900">Management Anggota</h1>
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative flex items-center">
                    <svg class="absolute left-3 w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input v-model="search" type="text" placeholder="Search Anggota"
                        class="pl-9 pr-10 py-2 text-sm border border-gray-200 rounded-lg w-56 focus:outline-none focus:border-gray-400 text-gray-700 placeholder-gray-400" />
                    <button class="absolute right-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                            <line x1="11" y1="18" x2="13" y2="18" />
                        </svg>
                    </button>
                </div>

                <!-- Tambah Anggota -->
                <button @click="openAdd"
                    class="flex items-center cursor-pointer gap-2 bg-gray-900 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Anggota
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-20">No</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-56">Nama</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4">Jabatan</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-48">Department</th>
                    <th class="text-left text-sm font-semibold text-gray-900 pb-4 w-24">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in paginatedData" :key="item.id"
                    class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-5 text-sm text-gray-700">{{ (currentPage - 1) * itemsPerPage + index + 1 }}.</td>
                    <td class="py-5 text-sm text-gray-700">{{ item.nama }}</td>
                    <td class="py-5 text-sm text-gray-700">{{ item.jabatan }}</td>
                    <td class="py-5 text-sm text-gray-700">{{ item.department }}</td>
                    <td class="py-5">
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
                            <div v-if="openMenu === item.id" @click.stop
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
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Tambah Anggota</h2>
                        <p class="text-xs text-gray-500">Isi data anggota baru di bawah ini</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Nama</label>
                        <input v-model="addForm.nama" type="text" placeholder="Masukkan nama lengkap"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 placeholder-gray-300" />
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Jabatan</label>
                        <div class="relative">
                            <select v-model="addForm.jabatan"
                                class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                <option value="" disabled>Pilih jabatan</option>
                                <option v-for="j in jabatanOptions" :key="j" :value="j">{{ j }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Department</label>
                        <div class="relative">
                            <select v-model="addForm.department"
                                class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                <option value="" disabled>Pilih department</option>
                                <option v-for="d in departmentOptions" :key="d" :value="d">{{ d }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button @click="showAddModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button @click=""
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
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Edit Anggota</h2>
                        <p class="text-xs text-gray-500">Ubah data anggota di bawah ini</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Nama</label>
                        <input v-model="editForm.nama" type="text"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400" />
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Jabatan</label>
                        <div class="relative">
                            <select v-model="editForm.jabatan"
                                class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                <option value="" disabled>Pilih jabatan</option>
                                <option v-for="j in jabatanOptions" :key="j" :value="j">{{ j }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="text-xs font-medium text-gray-600 mb-1 block">Department</label>
                        <div class="relative">
                            <select v-model="editForm.department"
                                class="w-full appearance-none border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm text-gray-800 focus:outline-none focus:border-gray-400 cursor-pointer">
                                <option value="" disabled>Pilih department</option>
                                <option v-for="d in departmentOptions" :key="d" :value="d">{{ d }}</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button @click="showEditModal = false"
                        class="px-4 py-2 text-sm cursor-pointer text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button @click=""
                        class="px-4 py-2 text-sm cursor-pointer text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        Simpan
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
                <h2 class="text-base font-semibold text-gray-900 mb-1">Hapus Anggota</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Apakah kamu yakin ingin menghapus
                    <span class="font-medium text-gray-800">{{ selectedItem?.nama }}</span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-2">
                    <button @click="showDeleteModal = false"
                        class="flex-1 px-4 py-2 text-sm text-gray-600 border cursor-pointer border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button @click=""
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
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import type { Anggota } from '@/types'
import { storeToRefs } from 'pinia'

const { getAllUser, confirmAdd, confirmDelete, saveUpdate } = useAuthStore()
const { user } = storeToRefs(useAuthStore())

// ── Dummy options ──
const jabatanOptions = [
    'Junior Software Engineer',
    'Senior Software Engineer',
    'Backend Developer',
    'Frontend Developer',
    'DevOps Engineer',
    'Data Analyst',
    'Product Designer',
    'UX Researcher',
    'Marketing and Communications Executive',
    'Social Media Manager',
    'Content Strategist',
    'Financial Operations Officer',
    'Accountant',
    'HR Manager',
    'Quality Assurance',
    'Security Engineer',
]

const departmentOptions = [
    'Technology',
    'Marketing',
    'Finance',
    'HR',
    'Design',
    'Operations',
    'Legal',
]

const search = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)
const openMenu = ref<number | null>(null)

// ── Modal state ──
const showAddModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedItem = ref<Anggota | null>(null)

const addForm = ref({ nama: '', jabatan: '', department: '' })
const editForm = ref({ nama: '', jabatan: '', department: '' })

// const allData = ref<Anggota[]>([
//     { id: 1, nama: 'Daniel Alexander Carter', jabatan: 'Senior Software Engineer', department: 'Technology' },
//     { id: 2, nama: 'Emily Grace Johnson', jabatan: 'Marketing and Communications Executive', department: 'Marketing' },
//     { id: 3, nama: 'Michael Benjamin Lee', jabatan: 'Financial Operations Officer', department: 'Finance' },
//     { id: 4, nama: 'Sophia Elizabeth Turner', jabatan: 'Quality Assurance', department: 'Technology' },
//     { id: 5, nama: 'Christopher Nathan Adams', jabatan: 'Financial Operations Officer', department: 'Finance' },
//     { id: 6, nama: 'Ava Rose Williams', jabatan: 'HR Manager', department: 'HR' },
//     { id: 7, nama: 'Liam James Anderson', jabatan: 'Backend Developer', department: 'Technology' },
//     { id: 8, nama: 'Olivia Marie Thomas', jabatan: 'Product Designer', department: 'Design' },
//     { id: 9, nama: 'Noah Henry Jackson', jabatan: 'Data Analyst', department: 'Technology' },
//     { id: 10, nama: 'Emma Claire White', jabatan: 'Content Strategist', department: 'Marketing' },
//     { id: 11, nama: 'William Scott Harris', jabatan: 'DevOps Engineer', department: 'Technology' },
//     { id: 12, nama: 'Isabella Kate Martin', jabatan: 'UX Researcher', department: 'Design' },
//     { id: 13, nama: 'James Oliver Thompson', jabatan: 'Accountant', department: 'Finance' },
//     { id: 14, nama: 'Mia Grace Garcia', jabatan: 'Social Media Manager', department: 'Marketing' },
//     { id: 15, nama: 'Benjamin Paul Martinez', jabatan: 'Security Engineer', department: 'Technology' },
// ])

const filteredData = computed(() =>
    user.value.filter(d =>
        d.nama.toLowerCase().includes(search.value.toLowerCase()) ||
        d.jabatan.toLowerCase().includes(search.value.toLowerCase()) ||
        d.department.toLowerCase().includes(search.value.toLowerCase())
    )
)

const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage.value))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    return filteredData.value.slice(start, start + itemsPerPage.value)
})

watch([itemsPerPage, search], () => { currentPage.value = 1 })

// ── Action menu ──
const toggleMenu = (id: number) => {
    openMenu.value = openMenu.value === id ? null : id
}
const closeMenu = () => { openMenu.value = null }
onMounted(() => {
    document.addEventListener('click', closeMenu)
    getAllUser()
})
onUnmounted(() => document.removeEventListener('click', closeMenu))

// ── Tambah ──
const openAdd = () => {
    addForm.value = { nama: '', jabatan: '', department: '' }
    showAddModal.value = true
}
// const saveAdd = () => {
//     if (!addForm.value.nama || !addForm.value.jabatan || !addForm.value.department) return
//     const newId = Math.max(...allData.value.map(d => d.id)) + 1
//     allData.value.push({ id: newId, ...addForm.value })
//     showAddModal.value = false
// }

// ── Edit ──
const openEdit = (item: Anggota) => {
    selectedItem.value = item
    editForm.value = { nama: item.nama, jabatan: item.jabatan, department: item.department }
    openMenu.value = null
    showEditModal.value = true
}
// const saveEdit = () => {
//     if (!selectedItem.value) return
//     const target = allData.value.find(d => d.id === selectedItem.value!.id)
//     if (target) Object.assign(target, editForm.value)
//     showEditModal.value = false
// }

// ── Hapus ──
const openDelete = (item: Anggota) => {
    selectedItem.value = item
    openMenu.value = null
    showDeleteModal.value = true
}
// const confirmDelete = () => {
//     allData.value = allData.value.filter(d => d.id !== selectedItem.value?.id)
//     showDeleteModal.value = false
// }
</script>