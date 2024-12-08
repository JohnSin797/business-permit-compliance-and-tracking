<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-200">
                <h1 class="text-2xl text-slate-900 font-bold">Create Business Permit Request</h1>
            </header>
            <form @submit.prevent="handleSubmit">
                <div class="w-full flex flex-col md:flex-row gap-2 mb-2">
                    <select name="business_name" id="business_name" class="p-2 rounded w-full md:w-1/2" v-model="this.business_id" :disabled="this.business_id != ''" required>
                        <option value="">select</option>
                        <option v-for="(business, index) in this.businesses" :key="index" :value="business.id">{{ business.business_name }}</option>
                    </select>
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
    import { useAuthStore } from '../../stores/auth';

    export default {
        data() {
            return {
                businesses: [],
                business_id: '',
                request_type: '',
                is_read_only: false,
            }
        },
        methods: {
            getBusiness() {
                const store = useAuthStore()
                axios.post('/business', { user_id: store.user.id })
                .then(response => {
                    if (response.data?.business) {
                        this.businesses = response.data?.business
                    } else {

                    }
                })
                .catch(error => {
                    console.log(error)
                })
            },
            handleSubmit() {
                const store = useAuthStore()
                axios.post('/request/store', {
                    business_id: this.business_id,
                    request_type: this.request_type,
                })
                .then(response => {
                    this.$router.push('/request/requirements/'+response.data?.id)
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getBusiness()
            this.business_id = this.$route.params?.business_id
        },
    }
</script>