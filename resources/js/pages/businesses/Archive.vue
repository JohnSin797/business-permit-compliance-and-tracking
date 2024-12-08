<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200 flex items-center justify-start gap-2">
                <router-link to="/business" class="p-2 rounded text-white bg-blue-400 hover:bg-blue-600">back</router-link>
                <h1 class="text-2xl text-slate-900 font-bold">Business Archive</h1>
                <!-- <router-link v-if="userData?.role == 'user'" to="/business/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
                    <v-icon name="md-noteadd-round" />
                    Create new
                </router-link> -->
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
                            <th>Actions</th>
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
                            <td class="p-2 border-b text-center text-indigo-900 font-bold">{{ business.permit_request.status }}</td>
                            <!-- <td>{{  }}</td> -->
                             <td class="p-2 border-b">
                                <div class="flex flex-wrap gap-2 justify-center items-center">
                                    <button @click="confirmRestore(business.id, index)" class="rounded p-2 text-xs font-bold bg-green-400 hover:bg-green-600 text-gray-200 hover:text-white">Restore</button>
                                    <button @click="confirmDelete(business.id, index)" class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white">Delete</button>
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
                businesses: []
            }
        },
        methods: {
            async getData() {
                const store = useAuthStore()
                const id = store.user.id
                await axios.post(`/api/business/archive`, {
                    user_id: id
                })
                .then(response => {
                    console.log(response)
                    this.businesses = response.data?.archive
                })
                .catch(error => {
                    console.log(error)
                })
            },
            confirmDelete(id, index) {
                Swal.fire({
                    title: 'Delete Business',
                    text: 'Are you sure you want to permanently delete business?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonColor: 'red',
                    confirmButtonColor: 'indigo',
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.deleteBusiness(id, index)
                    }
                })
            },
            confirmRestore(id, index) {
                Swal.fire({
                    title: 'Restore Business',
                    text: 'Are you sure you want to restore business?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonColor: 'red',
                    confirmButtonColor: 'indigo',
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.restoreBusiness(id, index)
                    }
                })},
            deleteBusiness(id, index) {
                axios.delete(`/api/business/destroy/${id}`)
                .then(() => {
                    const temp = [...this.businesses]
                    temp.splice(index, 1)
                    this.businesses = temp
                })
                .catch(error => {
                    console.log(error)
                })
            },
            restoreBusiness(id, index) {
                axios.patch(`/api/business/restore/${id}`)
                .then(() => {
                    const temp = [...this.businesses]
                    temp.splice(index, 1)
                    this.businesses = temp
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getData()
        },
    }
</script>