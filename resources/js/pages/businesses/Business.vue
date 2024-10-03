<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Businesses</h1>
                <router-link v-if="userData?.role == 'user'" to="/business/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
                    <v-icon name="md-noteadd-round" />
                    Create new
                </router-link>
            </header>
            <div class="w-full h-96 relative overflow-y-auto">
                <table class="w-full table-auto md:table-fixed">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Business Name</th>
                            <th>Address</th>
                            <th>Permit Status</th>
                            <!-- <th>Date Validated</th> -->
                            <th v-if="userData?.role == 'user'">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(business, index) in this.businesses" :key="index">
                            <td class="p-2 border-b text-center text-blue-200 font-bold">{{ business.business_name }}</td>
                            <td class="p-2 border-b text-center text-green-200">{{ business.business_address }}</td>
                            <td class="p-2 border-b text-center text-indigo-200">{{ getStatus(business.permit_request) }}</td>
                            <!-- <td>{{  }}</td> -->
                             <td class="p-2 border-b" v-if="userData?.role == 'user'">
                                <div class="flex flex-wrap gap-2 justify-center items-center">
                                    <!-- <button class="rounded p-2 text-xs font-bold bg-indigo-500 hover:bg-indigo-700 text-gray-200 hover:text-white">Request</button> -->
                                    <router-link 
                                        class="rounded p-2 text-xs font-bold bg-indigo-500 hover:bg-indigo-700 text-gray-200 hover:text-white" 
                                        :to="'/request/create/'+business.id"
                                    >
                                        Request
                                    </router-link>
                                    <button class="rounded p-2 text-xs font-bold bg-green-500 hover:bg-green-700 text-gray-200 hover:text-white">View</button>
                                    <button class="rounded p-2 text-xs font-bold bg-blue-500 hover:bg-blue-700 text-gray-200 hover:text-white">Edit</button>
                                    <button class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white">Delete</button>
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

    export default {
        data() {
            return {
                businesses: [],
                userData: {},
            }
        },
        methods: {
            getBusiness(id) {
                axios.post('/business', { user_id: id })
                .then(response => {
                    this.businesses = response.data?.business
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getAllBusiness(id) {
                axios.post('/business/admin', { user_id: id })
                .then(response => {
                    console.log(response)
                    this.businesses = response.data?.business
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getStatus(request) {
                const date = new Date();
                if (request) {
                    request.map(dat => {
                        if (new Date(dat.created_at).getFullYear() == date.getFullYear() && dat.status == 'confirmed') {
                            return 'Valid'
                        }
                    })
                }
                return 'Invalid'
            },
            getUser() {
                const store = useAuthStore()
                this.userData = store.user
                const user = store.user
                if (user?.role == 'admin') {
                    this.getAllBusiness(user.id)
                } else {
                    this.getBusiness(user.id)
                }
            },
        },
        mounted() {
            this.getUser()
        },
    }
</script>