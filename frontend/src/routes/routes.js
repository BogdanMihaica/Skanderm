import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserLoginView from '@/views/user/UserLoginView.vue'
import UserRegisterView from '@/views/user/UserRegisterView.vue'
import AdminUserListView from '@/views/admin/user/AdminUserListView.vue'
import OrderListView from '@/views/order/OrderListView.vue'
import ChatListView from '@/views/chat/ChatListView.vue'
import PlanListView from '@/views/plan/PlanListView.vue'

const routes = [
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
		path: '/sk-admin/orders',
		name: 'admin.orders.list',
		component: OrderListView
	},
	{
		path: '/sk-admin/chats',
		name: 'admin.chats.list',
		component: ChatListView
    },
	{
		path: '/sk-admin/plans',
		name: 'admin.plans.list',
		component: PlanListView
    },
];

export default routes
