<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200 flex justify-between items-center">
                <h1 class="text-2xl text-slate-900 font-bold">Business Permit Requests</h1>
                <router-link v-if="userData?.role == 'user'" to="/request/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
                    <v-icon name="md-noteadd-round" />
                    Create new
                </router-link>
            </header>
            <div class="relative w-full h-96 overflow-y-auto">
                <table class="w-full table-auto md:table-fixed">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Business</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(request, index) in this.requests" :key="index">
                            <td class="p-2 border-b text-center text-blue-900 font-bold">{{ request.business.business_name }}</td>
                            <td class="p-2 border-b text-center text-gray-900">{{ request.request_type }}</td>
                            <td class="p-2 border-b text-center text-green-900 font-semibold">{{ request.status }}</td>
                            <td class="p-2 border-b">
                                <div v-if="userData?.role == 'admin'" class="flex flex-wrap gap-2 justify-center items-center">
                                    <router-link 
                                        :to="`/request/view/${request?.id}`"
                                        class="rounded p-2 text-xs font-bold bg-green-500 hover:bg-green-700 text-gray-200 hover:text-white"
                                    >
                                        View
                                    </router-link>
                                    <!-- <button 
                                        @click="confirmConfirm(request.id)"
                                        :disabled="request.status!='pending'" 
                                        v-if="request.status!='confirmed'" 
                                        :class="`rounded p-2 text-xs font-bold text-gray-200 
                                        ${request.status != 'pending' ? 'bg-gray-400' : 'bg-indigo-400 hover:bg-indigo-600 hover:text-white'}`"
                                    >
                                        Confirm
                                    </button> -->
                                </div>
                                <div v-else class="flex flex-wrap gap-2 justify-center items-center">
                                    <router-link 
                                        v-if="this.userData.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                                        :to="`/request/requirements/${request.id}`" 
                                        class="rounded p-2 text-xs font-bold bg-cyan-400 hover:bg-cyan-600 text-gray-200 hover:text-white"
                                    >
                                        Uploads
                                    </router-link>
                                    <router-link 
                                        :to="`/request/view/${request.id}`" 
                                        class="rounded p-2 text-xs font-bold bg-green-400 hover:bg-green-600 text-gray-200 hover:text-white"
                                    >
                                        View
                                    </router-link>
                                    <button 
                                        v-if="request.status=='incomplete'||request.status=='pending'" 
                                        class="rounded p-2 text-xs font-bold bg-blue-500 hover:bg-blue-700 text-gray-200 hover:text-white"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        v-if="request.status=='incomplete'||request.status=='pending'" 
                                        class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import { useAuthStore } from '../../stores/auth';
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                requests: [],
                userData: {},
            }
        },
        methods: {
            confirmConfirm(id) {
                Swal.fire({
                    title: 'Request Confirmation',
                    text: 'Are you sure you want to confirm this request?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonColor: 'red',
                    confirmButtonColor: 'indigo',
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.confirmRequest(id)
                    }
                })
            },
            async confirmRequest(id) {
                await axios.patch(`/api/request/update/${id}`)
                .then(response => {
                    console.log(response)
                    const req = response.data?.request
                    this.requests = req
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'Confirmation Error',
                        text: error?.response?.data?.message,
                        icon: 'error'
                    })
                })
            },
            getRequests() {
                const store = useAuthStore()
                axios.post('/request', { user_id: store.user.id })
                .then(response => {
                    this.requests = response.data?.request
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getAllRequests(id) {
                axios.post('/request/admin', { user_id: id })
                .then(response => {
                    console.log(response)
                    this.requests = response.data?.request
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getUser() {
                const store = useAuthStore()
                this.userData = store.user
                const user = store.user

                if (user?.role == 'admin') {
                    this.getAllRequests(user?.id)
                } else {
                    this.getRequests()
                }
            },
        },
        mounted() {
            this.getUser()
        },
    }
</script>