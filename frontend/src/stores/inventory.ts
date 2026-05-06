import axiosInstance from "@/lib/axios";
import type { Inventaris } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useInventoryStore = defineStore('inventory', () => {
    const data = ref<Inventaris[]>([])

    const getAllData = async () => {
        try {
            const res = await axiosInstance('/all-inventory')
            console.log(res)

            data.value = res.data.data
        } catch(err) {
            console.log(err)
        }
    }

    const confirmAdd = async (payload: any) => {
        try {
            const res = await axiosInstance.post('/add-inventory', payload)
            console.log(res)

            await getAllData()
        } catch(err) {
            console.log(err)
        }
    }

    const confirmUpdate = async (payload: any, id: any) => {
        try {
            const res = await axiosInstance.put(`/update-inventory/${id}`, payload)
            console.log(res)

            await getAllData()
        } catch(err) {
            console.log(err)
        }
    }

    const confirmDelete = async (id: any) => {
        try {
            const res = await axiosInstance.delete(`/del-inventory/${id}`)
            console.log(res)

            await getAllData()
        } catch(err) {
            console.log(err)
        }
    }

    return {
        data,
        getAllData,
        confirmAdd,
        confirmDelete,
        confirmUpdate,
    }
}, {
    persist: true
})