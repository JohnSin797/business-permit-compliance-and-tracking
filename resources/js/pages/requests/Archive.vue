<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200 flex items-center justify-start gap-2">
                <router-link to="/request" class="p-2 rounded text-white bg-blue-400 hover:bg-blue-600">back</router-link>
                <h1 class="text-2xl text-slate-900 font-bold">Permit Request Archive</h1>
            </header>
            <div class="w-full h-80 2xl:h-96 relative overflow-y-auto">
                <table class="w-full table-auto md:table-fixed">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Business Name</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Request Type</th>
                            <th>Permit Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(permit, index) in this.permits" :key="index">
                            <td class="p-2 border-b text-center text-blue-700 font-bold">{{ permit.business.business_name }}</td>
                            <td class="p-2 border-b text-center text-green-600">{{ permit.business.business_address }}</td>
                            <td class="p-2 border-b text-sm text-center text-black font-semibold">
                                {{ permit.business.owner.first_name }} {{ permit.business.owner.middle_name }} {{ permit.business.owner.last_name }} {{ permit.business.owner.extension }}
                            </td>
                            <td class="p-2 border-b text-sm text-center text-black font-semibold">{{ permit?.request_type }}</td>
                            <td class="p-2 border-b text-center text-indigo-900 font-bold">{{ permit.status }}</td>
                            <!-- <td>{{  }}</td> -->
                             <td class="p-2 border-b">
                                <div class="flex flex-wrap gap-2 justify-center items-center">
                                    <button @click="confirmRestore(permit.id, index)" class="rounded p-2 text-xs font-bold bg-green-400 hover:bg-green-600 text-gray-200 hover:text-white">Restore</button>
                                    <button @click="confirmDelete(permit.id, index)" class="rounded p-2 text-xs font-bold bg-red-400 hover:bg-red-600 text-gray-200 hover:text-white">Delete</button>
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
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                permits: []
            }
        },
        methods: {
            getData() {
                axios.put('/api/request/archive', {})
                .then(response => {
                    console.log(response)
                    this.permits = response.data?.archive
                })
                .catch(error => {
                    console.log(error)
                })
            },
            confirmRestore(id, index) {
                Swal.fire({
                    title: 'Restore Confirmation',
                    text: 'Are you sure you want to restore?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.restoreArchive(id, index)
                    }
                })
            },
            confirmDelete(id, index) {
                Swal.fire({
                    title: 'Restore Confirmation',
                    text: 'Are you sure you want to restore?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                })
                .then(response => {
                    if (response.isConfirmed) {
                        this.deleteArchive(id, index)
                    }
                })},
            restoreArchive(id, index) {
                axios.patch(`/api/request/restore/${id}`)
                .then(() => {
                    const temp = [...this.permits]
                    temp.splice(index, 1)
                    this.permits = temp
                })
                .catch(error => {
                    console.log(error)
                })
            },
            deleteArchive(id, index) {
                axios.delete(`/api/request/destroy/${id}`)
                .then(() => {
                    const temp = [...this.permits]
                    temp.splice(index, 1)
                    this.permits = temp
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