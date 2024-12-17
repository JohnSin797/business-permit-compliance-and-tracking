<template>
    <div class="w-full h-[500px] mt-16 2xl:h-[655px] overflow-auto px-3 md:px-20" ref="scrollContainer" @scroll="handleScroll">
        <!-- <VerificationForm v-if="isVerified" :handleSubmit="this.handleVerification" /> -->
        <RequestWindow />
        <div class="w-full flex flex-col justify-center items-center gap-10 p-2">
            <section class="w-full " v-if="userData.role=='admin'">
                <header class="font-semibold">
                    <h1 class="text-xl text-center text-gray-800">Post Announcements</h1>
                </header>
                <form @submit.prevent="postAnnouncement">
                    <div class="flex justify-center items-center gap-2">
                        <input type="text" name="message" id="message" v-model="this.blog.message" class="w-full p-2 text-sm rounded-lg shadow-xl ring-2 ring-gray-400" />
                        <button type="submit" class="w-1/6 p-2 text-sm text-white rounded-lg bg-blue-400 hover:bg-blue-600 shadow-xl">
                            <v-icon name="fa-paper-plane" scale="1" />
                        </button>
                    </div>
                </form>
            </section>
            <article class="w-full p-10 rounded-lg shadow-xl bg-gray-400" v-for="(ann,index) in announcements" :key="index">
                <header class="font-bold">{{ new Date(ann.created_at).toISOString().substring(0, 16).replace('T', ' ') }}</header>
                <div class="p-2 w-full">
                    <div class="w-full border border-gray-400" v-if="ann.images"></div>
                    <p>{{ ann.message }}</p>
                </div>
            </article>
            <section v-if="loading" class="w-full max-w-[550px] p-10 flex justify-center items-center">
                <v-icon name="fa-spinner" scale="1.8" class="animate-spin text-white" />
            </section>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import VerificationForm from '../components/VerificationForm.vue';
    import { useAuthStore } from '../stores/auth';
    import RequestWindow from '../components/RequestWindow.vue';

    export default {
        data() {
            return {
                isVerified: false,
                blog: {
                    message: '',
                },
                announcements: [],
                loading: false,
                allPostLoaded: false,
                userData: {},
            }
        },
        components: {
            VerificationForm, RequestWindow
        },
        methods: {
            handleScroll() {
                const container = this.$refs.scrollContainer
                console.log(container.scrollTop, container)
                if (container.scrollTop + container.clientHeight >= container.scrollHeight) {
                    if (!this.loading)
                    this.getMorePost()
                }
            },
            getMorePost() {
                this.loading = true
                axios.get(`/api/post/old/${this.announcements[this.announcements.length-1].id}`)
                .then(response => {
                    const old = response.data?.posts
                    this.announcements = [...this.announcements, ...old]
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
            },
            handleVerification(code) {
                const store = useAuthStore()
                axios.post('/user/verify-email', { 
                    user_id: store.user.id,
                    verification_code: code 
                })
                .then(response => {
                    store.getUser(response.data?.user)
                    this.checkIfVerified
                })
                .catch(error => {
                    console.log(error)
                })
            },
            checkIfVerified() {
                const store = useAuthStore()
                const verified = store.user?.email_verified_at
                this.isVerified = verified == null
            },
            postAnnouncement(e) {
                e.preventDefault()
                this.loading = true
                axios.post('/api/post/store', this.blog)
                .then(response => {
                    const p = response.data?.post
                    this.announcements = [p, ...this.announcements]
                    this.blog = {
                        message: '',
                    }
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
            },
            getAnnouncements() {
                this.loading = true
                axios.get('/api/post')
                .then(response => {
                    const p = response.data?.posts
                    this.announcements = p
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
            },
            getUser() {
                const store = useAuthStore()
                this.userData = store.user
            },
        },
        mounted() {
            this.getUser()
            this.checkIfVerified()
            this.getAnnouncements()
            this.$refs.scrollContainer.addEventListener("scroll", this.handleScroll)
        },
    }
</script>