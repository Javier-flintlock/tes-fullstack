import axiosInstance from "@/lib/axios";
import type { Anggota } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore('auth', () => {
    const user = ref<Anggota[]>([])
    const token = ref(null)
    const isSynced = ref(false)

    const getAllUser = async () => {
        try {
            const res = await axiosInstance.get('/users')
            console.log(res)

            user.value = res.data
            isSynced.value = true

        } catch(err) {
            console.log(err)
        }
    }

    const saveUpdate = () => {

    }
    const confirmAdd = () => {

    }
    const confirmDelete = () => {

    }

    return {
        user,
        getAllUser,
        saveUpdate,
        confirmAdd,
        confirmDelete,
    }
}, {
    persist: true
})