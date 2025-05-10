import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserLoginView from '@/views/user/UserLoginView.vue'
import UserRegisterView from '@/views/user/UserRegisterView.vue'
import AdminUserListView from '@/views/admin/user/AdminUserListView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/auth/login',
      name: 'auth.login',
      component: UserLoginView,
    },
    {
      path: '/auth/register',
      name: 'auth.register',
      component: UserRegisterView,
    },
    {
      path: '/sk-admin',
      name: 'admin.dashboard',
      component: UserRegisterView,
    },
    {
      path: '/sk-admin/users',
      name: 'admin.users.list',
      component: AdminUserListView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
  ],
})

export default router
