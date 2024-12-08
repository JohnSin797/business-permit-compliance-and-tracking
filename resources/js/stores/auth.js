import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null,
        accessToken: null,
        profileImage: null,
    }),
    getters: {
        user: (state) => state.authUser,
        token: (state) => state.accessToken,
    },
    actions: {
        getUser(user) {
            this.authUser = user;
        },
        getToken(token) {
            this.accessToken = token;
        },
        logout() {
            this.authUser = null;
            this.accessToken = null;
        },
        setProfileImage(imageUrl) {
            this.profileImage = imageUrl
        },
    },
    persist: true
});