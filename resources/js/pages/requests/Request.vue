<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Business Permit Requests</h1>
                <router-link to="/request/create" class="text-sm hover:text-white bg-blue-400 hover:bg-blue-600 font-bold p-2 rounded">
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
                            <td class="p-2 border-b text-center text-blue-200 font-bold">{{ request.business.business_name }}</td>
                            <td class="p-2 border-b text-center text-gray-400">{{ request.request_type }}</td>
                            <td class="p-2 border-b text-center text-green-200">{{ request.status }}</td>
                            <td  class="p-2 border-b">
                                <div class="flex flex-wrap gap-2 justify-center items-center">
                                    <router-link :to="`/request/requirements/${request.id}`" class="rounded p-2 text-xs font-bold bg-green-500 hover:bg-green-700 text-gray-200 hover:text-white">
                                        View
                                    </router-link>
                                    <!-- <button class="rounded p-2 text-xs font-bold bg-blue-500 hover:bg-blue-700 text-gray-200 hover:text-white">Edit</button> -->
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
                requests: []
            }
        },
        methods: {
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
            }
        },
        mounted() {
            this.getRequests()
        },
    }
</script>