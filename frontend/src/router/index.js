import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import DaftarPasien from '../views/DaftarPasien.vue'
import DetailPathway from '../views/DetailPathway.vue'

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/patients',
    name: 'DaftarPasien',
    component: DaftarPasien
  },
  {
    path: '/patients/:id',
    name: 'DetailPathway',
    component: DetailPathway
  },
  {
    path: '/clinical-pathway',
    name: 'ClinicalPathway',
    component: () => import('../components/forms/ClinicalPathwayForm.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
