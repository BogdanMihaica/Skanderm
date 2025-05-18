import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null
    }),

    getters: {
        getUser: (state) => state.user,
    },

    actions: {
        /**
         * Sets the store user to a specified user
         * @param user object
         */
        setUser(user) {
            this.user = user;
        },
    }
})
