import { createRouter, createWebHistory } from 'vue-router'
import DataInventaris from '../views/DataInventaris.vue'
import ManagementAnggota from '../views/ManagementAnggota.vue'
import Analytics from '../views/Analytics.vue'
import Dashboard from '@/views/Dashboard.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: Dashboard,
      redirect: '/management-anggota',
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
    }
  ],
})

router.afterEach((to) => {
  document.title = (to.meta.title as string) || 'Page'
})

export default router
