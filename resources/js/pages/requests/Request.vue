<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200 flex justify-between items-center">
                <h1 class="text-2xl text-slate-900 font-bold">Business Permit Requests</h1>
                <div v-if="userData?.role == 'user'" class="flex justify-center items-center gap-2">
                    <router-link to="/request/archive" class="text-sm hover:text-white bg-gray-400 hover:bg-gray-600 font-bold p-2 rounded">Archive</router-link>
                    <router-link to="/request/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
                        <v-icon name="md-noteadd-round" />
                        Create new
                    </router-link>
                </div>
                <input @input="handleSearch" v-if="userData?.role=='admin'" type="text" class="p-2 rounded text-sm text-slate-900 w-1/3" placeholder="Search..." />
            </header>
            <div class="relative w-full h-80 2xl:h-96 overflow-y-auto">
                <table class="w-full table-auto md:table-fixed">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Business</th>
                            <th v-if="userData.role=='admin'">Owner</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(request, index) in this.requests" :key="index">
                            <td class="p-2 border-b text-center text-blue-900 font-bold">{{ request.business.business_name }}</td>
                            <td v-if="userData.role=='admin'" class="p-2 border-b text-center text-gray-900">
                                <span>{{ request.business.owner.first_name }} </span>
                                <span>{{ request.business.owner.middle_name_name }} </span>
                                <span>{{ request.business.owner.last_name }} </span>
                                <span>{{ request.business.owner.extension }} </span>
                            </td>
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
                                    <router-link
                                        :to="`/request/edit/${request.id}`"
                                        v-if="request.status=='incomplete'||request.status=='pending'" 
                                        class="rounded p-2 text-xs font-bold bg-blue-500 hover:bg-blue-700 text-gray-200 hover:text-white"
                                    >
                                        Edit
                                    </router-link>
                                    <button 
                                        @click="confirmArchive(request.id, index)"
                                        v-if="request.status=='incomplete'||request.status=='pending'" 
                                        class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white"
                                    >
                                        Archive
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
                requestsArr: [],
                userData: {},
            }
        },
        methods: {
            handleSearch(event) {
                const key = event.target.value
                const temp = this.requestsArr.filter(r => 
                    r.business.business_name.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.business_address.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.owner?.first_name.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.owner?.middle_name.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.owner?.last_name.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.owner?.extension?.toLowerCase().includes(key.toLowerCase()) ||
                    r.business.type_of_organization.toLowerCase().includes(key.toLowerCase())
                )
                this.requests = temp
            },
            getRequests() {
                const store = useAuthStore()
                axios.post('/request', { user_id: store.user.id })
                .then(response => {
                    const req = response.data?.request
                    this.requests = req
                    this.requestsArr = req
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getAllRequests(id) {
                axios.post('/request/admin', { user_id: id })
                .then(response => {
                    const req = response.data?.request
                    this.requests = req
                    this.requestsArr = req
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
            confirmArchive(id, index) {
                Swal.fire({
                    title: 'Archive Confirmation',
                    text: 'Are you sure you want to archive permit request?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.archivePermit(id, index)
                    }
                })
            },
            archivePermit(id, index) {
                axios.delete(`/api/request/delete/${id}`)
                .then(() => {
                    const temp = [...this.requests]
                    temp.splice(index, 1)
                    this.requests = temp
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getUser()
        },
    }
</script>