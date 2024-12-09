<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200 flex items-center justify-between">
                <h1 class="text-2xl text-slate-900 font-bold">Businesses</h1>
                <input @input="handleSearch" v-if="userData?.role=='admin'" type="text" class="p-2 rounded text-sm text-slate-900 w-1/3" placeholder="Search..." />
                <div v-if="userData?.role == 'user'" class="flex flex-wrap justify-center items-center gap-2">
                    <router-link to="/business/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
                        <v-icon name="md-noteadd-round" />
                        Create new
                    </router-link>
                    <router-link to="/business/archive" class="text-sm hover:text-white bg-zinc-400 hover:bg-zinc-600 p-2 rounded">Archive</router-link>
                </div>
            </header>
            <div class="w-full h-80 2xl:h-96 relative overflow-y-auto">
                <table class="w-full table-auto md:table-fixed">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Business Name</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Ownership</th>
                            <th>Permit Status</th>
                            <!-- <th>Date Validated</th> -->
                            <th v-if="userData?.role == 'user'">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(business, index) in this.businesses" :key="index">
                            <td class="p-2 border-b text-center text-blue-700 font-bold">{{ business.business_name }}</td>
                            <td class="p-2 border-b text-center text-green-600">{{ business.business_address }}</td>
                            <td class="p-2 border-b text-sm text-center text-black font-semibold">
                                {{ business.owner.first_name }} {{ business.owner.middle_name }} {{ business.owner.last_name }} {{ business.owner.extension }}
                            </td>
                            <td class="p-2 border-b text-sm text-center text-black font-semibold">{{ business?.type_of_organization }}</td>
                            <td class="p-2 border-b text-center text-indigo-900 font-bold">{{ getStatus(business.permit_request) }}</td>
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
                                    <router-link :to="`/business/view/${business.id}`" class="block rounded p-2 text-xs font-bold bg-green-500 hover:bg-green-700 text-gray-200 hover:text-white">View</router-link>
                                    <router-link :to="`/business/edit/${business.id}`" class="block rounded p-2 text-xs font-bold bg-blue-500 hover:bg-blue-700 text-gray-200 hover:text-white">Edit</router-link>
                                    <button @click="confirmDelete(business.id)" class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white">Archive</button>
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
                businesses: [],
                businessArr: [],
                userData: {},
            }
        },
        methods: {
            handleSearch(event) {
                console.log(event)
                const key = event.target.value
                console.log(key)
                const temp = this.businessArr.filter(b => 
                    b.business_name.toLowerCase().includes(key.toLowerCase()) ||
                    b.business_address.toLowerCase().includes(key.toLowerCase()) ||
                    b.owner?.first_name.toLowerCase().includes(key.toLowerCase()) ||
                    b.owner?.middle_name.toLowerCase().includes(key.toLowerCase()) ||
                    b.owner?.last_name.toLowerCase().includes(key.toLowerCase()) ||
                    b.owner?.extension?.toLowerCase().includes(key.toLowerCase()) ||
                    b.type_of_organization.toLowerCase().includes(key.toLowerCase())
                )
                this.businesses = temp
            },
            getBusiness(id) {
                axios.post('/business', { user_id: id })
                .then(response => {
                    this.businesses = response.data?.business
                    this.businessArr = response.data?.business
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
                    this.businessArr = response.data?.business
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
            async deleteBusiness(id) {
                await axios.patch(`/api/business/delete/${id}`)
                .then(response => {
                    console.log(response)
                    const b = response.data?.business
                    this.businesses = b
                    this.businessArr = b
                })
                .catch(error => {
                    console.log(error)
                })
            },
            confirmDelete(id) {
                Swal.fire({
                    title: 'Confirm Archive',
                    text: 'Are you sure you want to archive this?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonColor: 'red',
                    confirmButtonColor: 'indigo',
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.deleteBusiness(id)
                    }
                })
            },
        },
        mounted() {
            this.getUser()
        },
    }
</script>