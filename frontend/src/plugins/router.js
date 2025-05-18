import {createRouter, createWebHistory} from "vue-router";
import routes from '@/routes/routes.js'

export default {
    install(Vue) {
        const router = createRouter({
            history: createWebHistory(import.meta.env.BASE_URL),
            routes: routes
        });

        router.beforeEach(async (to, from, next) => {
            const auth = Vue.config.globalProperties.$auth;

            try {
                await auth.fetchUser();
            } catch {
                console.warn('Error while fetching user');
            }
            
            // if (to.meta.guest && auth.isLoggedIn()) {
            //     return next({name: 'dashboard'});
            // } else if (to.meta.auth && !auth.isLoggedIn()) {
            //     return next({name: 'login'});
            // } else if (to.meta.auth && !auth.user()?.is_admin) {
            //     return next({name: 'forbidden'});
            // }

            return next();
        });

        Vue.use(router);
    }
}