import { createRouter, createWebHistory } from 'vue-router'
import DataInventaris from '../views/DataInventaris.vue'
import ManagementAnggota from '../views/ManagementAnggota.vue'
import Analytics from '../views/Analytics.vue'
import Dashboard from '@/views/Dashboard.vue'
import { useAuthStore } from '@/stores/auth'
import Login from '@/views/Login.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: Dashboard,
      redirect: '/management-anggota',
      meta: { requiresAuth: true },
      children: [
        {
          path: '/management-anggota',
          name: 'management-anggota',
          component: ManagementAnggota,
          meta: { title: 'Management Anggota' },
        },
        {
          path: '/data-inventaris',
          name: 'data-inventaris',
          component: DataInventaris,
          meta: { title: 'Data Inventaris' }
        },
        {
          path: '/analytics',
          name: 'analytics',
          component: Analytics,
          meta: { title: 'Analytics' }
        },
      ]
    },
    {
      path: '/management-anggota',
      redirect: '/'
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    }
  ],
})

router.afterEach((to) => {
  document.title = (to.meta.title as string) || 'Page'
})

router.beforeEach((to, before, next) => {
  const { isSynced } = useAuthStore()
  if (to.matched.some((record) => record.meta.requiresAuth && !isSynced)) next('/login')
  else if (to.matched.some((record) => record.meta.requiresGuest && isSynced)) next('/')

  else next()
})

export default router
