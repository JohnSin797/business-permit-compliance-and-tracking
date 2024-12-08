<template>
    <div class="fixed top-0 right-0 w-full md:w-5/6 bg-slate-900 flex justify-end items-center gap-10 p-2 z-10">
        <div class="relative text-gray-200">
            <p class="text-sm">notifications</p>
        </div>
        <div class="relative">
            <div @click="()=>showMenu=!showMenu" class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden ring-white ring-2 hover:ring-cyan-400 cursor-pointer">
                <img :src="profileImage" alt="profile-image" />
            </div>
            <div :class="{'absolute rounded border-2 border-gray-400 top-14 right-0 w-80 bg-slate-900 p-5': showMenu, 'hidden': !showMenu}">
                <p class="text-center text-lg text-white font-semibold mb-5">{{ userData.first_name }} {{ userData.middle_name }} {{ userData.last_name }} {{ userData.extension }}</p>
                <ul class="text-white text-sm">
                    <button class="p-2 w-full rounded font-bold bg-blue-400 hover:bg-blue-600">logout</button>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from '../stores/auth';

    export default {
        data() {
            return {
                profileImage: null,
                showMenu: false,
                userData: {},
            }
        },
        methods: {
            getUserData() {
                const store = useAuthStore()
                this.profileImage = store.profileImage
                this.userData = store.user
            },  
        },
        mounted() {
            this.getUserData()
        },
    }
</script>