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
            <div class="w-full h-96 relative overflow-y-auto">
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
                            <td class="p-2 border-b text-center text-indigo-900 font-bold">{{ getStatus(business.permit_request) }}</td>
                            <!-- <td>{{  }}</td> -->
                             <td class="p-2 border-b">
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
                await axios.get(`/api/business/archive/${id}`)
                .then(response => {
                    console.log(response)
                    this.businesses = response.data?.archive
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