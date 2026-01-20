import { createRouter, createWebHistory } from 'vue-router'
import JobApplicationsView from '../views/JobApplicationsView.vue'

const routes = [{ path: '/', name: 'jobapplications', component: JobApplicationsView }]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes,
})

export default router
