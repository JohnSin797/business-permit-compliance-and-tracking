<template>
    <div class="w-full flex flex-col md:flex-row justify-center items-center gap-2 mb-10">
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Incomplete Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="fa-minus-circle" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">{{ this.incomplete }}</p>
                </div>
            </div>
        </section>
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Pending Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="md-pendingactions" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">{{ this.pending }}</p>
                </div>
            </div>
        </section>
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Rejected Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="fa-trash-alt" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">{{ this.rejected }}</p>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import { useAuthStore } from '../stores/auth';

    export default {
        data() {
            return {
                incomplete: 0,
                pending: 0,
                rejected: 0,
            }
        },
        methods: {
            countRequest(requestData) {
                console.log(this.requestData)
                requestData.map(data => {
                    if (data.status == 'incomplete') {
                        this.incomplete++
                    } else if (data.status == 'pending') {
                        this.pending++
                    } else if (data.status == 'rejected') {
                        this.rejected++
                    }
                })
            },
            getRequests() {
                const store = useAuthStore()
                const id = store.user.id
                axios.post('/request', { user_id: id })
                .then(response => {
                    console.log(response)
                    this.countRequest(response.data?.request)
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.getRequests()
        },
    }
</script>