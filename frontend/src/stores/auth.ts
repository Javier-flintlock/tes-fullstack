import axiosInstance from "@/lib/axios";
import router from "@/router";
import type { Anggota } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore('auth', () => {
    const data = ref<Anggota[]>([])
    const user = ref<Anggota | null>(null)
    const isSynced = ref(false)

    const getAllUser = async () => {
        try {
            const res = await axiosInstance.get('/users')
            console.log(res)

            data.value = res.data?.data

        } catch (err) {
            console.log(err)
        }
    }

    const login = async (payload: any) => {
        try {
            const res = await axiosInstance.post('/login', payload)

            const token = res.data?.data.token
            localStorage.setItem('token', token)

            axiosInstance.defaults.headers.common['Authorization'] = `Bearer${token}`

            await getUser()
            router.push('/')
        } catch (err) {
            console.log(err)
        }
    }

    const logout = async () => {
        try {
            const res = await axiosInstance.post('/logout')
            console.log(res)

            isSynced.value = false
            user.value = null
            localStorage.removeItem('token')
            delete axiosInstance.defaults.headers.common['Authorization']

            window.location.reload()
        } catch (err) {
            console.log(err)
        }
    }

    const getUser = async () => {
        try {
            const res = await axiosInstance.get('/user', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })

            user.value = res.data.data
            isSynced.value = true
        } catch (err) {
            console.log(err)
        }
    }

    const saveUpdate = async (payload: any, id: any) => {
        try {
            const res = await axiosInstance.put(`/update-user/${id}`, payload)
            console.log(res)

            await getAllUser()
        } catch (err) {
            console.log(err)
        }
    }
    const confirmAdd = async (payload: any) => {
        try {
            const res = await axiosInstance.post('/add-user', payload)
            console.log(res)

            await getAllUser()
        } catch (err) {
            console.log(err)
        }
    }
    const confirmDelete = async (id: any) => {
        try {
            const res = await axiosInstance.delete(`/del-user/${id}`)
            console.log(res.data)

            await getAllUser()
        } catch (err) {
            console.log(err)
        }
    }

    return {
        data,
        getAllUser,
        saveUpdate,
        confirmAdd,
        confirmDelete,
        isSynced,
        login,
        getUser,
        logout,
        user,
    }
}, {
    persist: true
})