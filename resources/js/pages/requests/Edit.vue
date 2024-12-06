<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-2xl font-bold">Create Business Permit Request</h1>
            </header>
            <form @submit.prevent="handleSubmit">
                <div class="w-full flex flex-col md:flex-row gap-2 mb-2">
                    <input 
                        type="text" 
                        name="business_name" 
                        id="business_name" 
                        class="p-2 rounded w-full md:w-1/2" 
                        v-model="this.business_name"
                        readonly
                    />
                    <select name="request_type" id="request_type" class="p-2 rounded w-full md:w-1/2" v-model="this.request_type" required>
                        <option value="">select</option>
                        <option value="new">new</option>
                        <option value="renewal">renewal</option>
                    </select>
                </div>
                <button type="submit" class="p-2 rounded text-sm w-full md:w-1/5 bg-blue-400 hover:bg-blue-600 text-white font-bold">submit</button>
            </form>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                business_name: '',
                request_type: '',
            }
        },
        methods: {
            async getBusiness() {
                const id = this.$route.params.request_id
                await axios.get(`/api/request/show/${id}`)
                .then(response => {
                    const b = response.data?.business
                    this.business_name = b?.business_name
                    this.request_type = b?.request_type
                })
                .catch(error => {
                    console.log(error)
                })
            },
            async handleSubmit(event) {
                event.preventDefault()
                const id = this.$route.params.request_id_id
                await axios.put(`/api/request/edit/${id}`, {
                    business_name: this.business_name,
                    request_type: this.request_type
                })
                .then(response => {
                    console.log(response)
                    Swal.fire({
                        title: 'Edit Request',
                        text: 'Request has been successfully updated',
                        icon: 'success',
                    })
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getBusiness()
        },
    }
</script>