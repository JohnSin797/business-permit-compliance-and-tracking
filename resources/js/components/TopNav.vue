<template>
    <div class="fixed top-0 right-0 w-full md:w-5/6 bg-slate-900 flex justify-end items-center gap-10 p-2 z-10">
        <div class="relative text-gray-200">
            <button 
                @click="toggleNotification"
                class="rounded-full w-10 h-10 ring-2 ring-slate-900 relative hover:ring-cyan-400 z-10"
            >
                <span v-if="isUnread" class="w-3 h-3 absolute top-0 right-0 bg-red-500 rounded-full animate-ping"></span>
                <span v-if="isUnread" class="w-3 h-3 absolute top-0 right-0 bg-red-500 rounded-full"></span>
                <v-icon name="fa-bell" scale="1.8" />
            </button>
            <div v-if="showNotification" class="fixed md:absolute p-3 md:p-5 pt-14 md:pt-14 top-0 right-0 h-full md:h-96 w-full md:w-80 bg-slate-900">
                <header class="mb-5 font-semibold">
                    <h1 class="text-xl">Notfications</h1>
                </header>
                <div class="h-96 overflow-y-auto flex flex-col gap-2">
                    <div v-for="(notification,index) in notifications" class="w-full border-b">
                        <header class="text-xs font-bold">
                            <p>{{ new Date(notification.created_at).toLocaleDateString('en-PH') }}</p>
                        </header>
                        <div class="flex justify-between items-center pl-3 pb-2">
                            <p class="text-xs">{{ notification.content }}</p>
                            <button @click="deleteNotification(notification.id, index)" class="text-red-400 hover:text-red-700 rounded p-1 border border-slate-900 hover:border-red-400">
                                <v-icon name="fa-trash" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative">
            <div @click="()=>showMenu=!showMenu" class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden ring-white ring-2 hover:ring-cyan-400 cursor-pointer z-10">
                <img :src="profileImage" alt="profile-image" />
            </div>
            <div :class="{'fixed md:absolute p-3 md:p-5 mt-14 md:mt-12 top-0 right-0 h-full md:h-96 w-full md:w-80 bg-slate-900': showMenu, 'hidden': !showMenu}">
                <p class="text-center text-lg text-white font-semibold mb-5">{{ userData.first_name }} {{ userData.middle_name }} {{ userData.last_name }} {{ userData.extension }}</p>
                <ul class="text-white text-sm">
                    <div class="flex flex-col gap-2 mb-2 md:hidden">
                        <button @click="goTo('/')" :class="{'bg-gray-800': isLinkActive('/')}" class="p-2 w-full rounded font-bold border border-white active:bg-gray-800">Home</button>
                        <button @click="goTo('/business')" :class="{'bg-gray-800': isLinkActive('/business')}" class="p-2 w-full rounded font-bold border border-white active:bg-gray-800">Business</button>
                        <button @click="goTo('/request')" :class="{'bg-gray-800': isLinkActive('/request')}" class="p-2 w-full rounded font-bold border border-white active:bg-gray-800">Request</button>
                        <button @click="goTo('/profile')" :class="{'bg-gray-800': isLinkActive('/profile')}" class="p-2 w-full rounded font-bold border border-white active:bg-gray-800">Profile</button>
                    </div>
                    <button @click="logout" class="p-2 w-full rounded font-bold bg-blue-400 hover:bg-blue-600">logout</button>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth';

    export default {
        data() {
            return {
                profileImage: null,
                showMenu: false,
                userData: {},
                notifications: [],
                showNotification: false,
            }
        },
        computed: {
            isUnread() {
                return this.notifications?.some(t => t.status === 'unread')
            },
        },
        methods: {
            isLinkActive(link) {
                if (link === '/') {
                    return this.$route.path === link
                }
                else {
                    return this.$route.path.startsWith(link)
                }
            },
            goTo(path) {
                this.showMenu = false
                this.$router.push(path)
            },
            deleteNotification(id, index) {
                axios.delete(`/api/notification/delete/${id}`)
                .then(() => {
                    const temp = [...this.notifications]
                    temp.splice(index, 1)
                    this.notifications = temp
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getUserData() {
                const store = useAuthStore()
                this.profileImage = store.profileImage
                this.userData = store.user
            },  
            getNotifications() {
                const store = useAuthStore()
                const id = store.user.id
                axios.post(`/api/notification/show/${id}`)
                .then(response => {
                    console.log(response)
                    this.notifications = response.data?.notifications
                })
                .catch(error => {
                    console.log(error)
                })
            },
            toggleNotification() {
                this.showNotification = !this.showNotification
                this.readNotification()
            },
            logout() {
                const store = useAuthStore()
                store.logout()
                this.$router.push('/sign-in')
            },
            readNotification() {
                const store = useAuthStore()
                const id = store.user.id
                axios.patch(`/api/notification/update/${id}`)
                .then(response => {
                    console.log(response)
                    this.notifications = response.data?.notifications
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getUserData()
            this.getNotifications()
        },
    }
</script>