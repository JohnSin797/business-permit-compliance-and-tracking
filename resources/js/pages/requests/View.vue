<template>
    <div class="w-full min-h-screen flex flex-col justify-center items-center gap-10 py-10">
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="text-gray-900 flex justify-start items-start gap-2">
                <router-link to="/request" class="block p-2 rounded text-white bg-blue-400 hover:bg-blue-600">
                    <v-icon name="fa-arrow-left" />
                </router-link>
                <h1 class="text-2xl font-bold">Business Permit Requirements</h1>
            </header>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">Barangay Clearance</h1>
            </header>
            <div class="w-full relative h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.barangay_clearance" 
                    :src="'/storage/'+request.requirements?.barangay_clearance" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">Application Form</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.application_form" 
                    :src="'/storage/'+request.requirements?.application_form" 
                    alt="barangay-clearance"
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">Cedula</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.cedula" 
                    :src="'/storage/'+request.requirements?.cedula" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">Business Registration</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.business_registration" 
                    :src="'/storage/'+request.requirements?.business_registration" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">BIR Certificate of Registration</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.bir_certificate_of_registration" 
                    :src="'/storage/'+request.requirements?.bir_certificate_of_registration" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">Notarized Contract of Lease</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.notarized_contract_of_lease" 
                    :src="'/storage/'+request.requirements?.notarized_contract_of_lease" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-xl font-bold">ECC or CNC (if applicable DENR)</h1>
            </header>
            <div class="w-full h-80 border border-gray-400 block text-gray-400 flex justify-center items-center">
                <img 
                    v-if="request?.requirements?.ecc_cnc_denr" 
                    :src="'/storage/'+request.requirements?.ecc_cnc_denr" 
                    alt="barangay-clearance" 
                    class="w-full h-full object-contain"
                >
                <div v-else class="">
                    <router-link 
                        v-if="userData?.role=='user'&&(request.status=='incomplete'||request.status=='pending')" 
                        :to="`/request/requirements/${request?.id}`" 
                        class="text-gray-400 font-semibold hover:underline hover:text-white"
                    >
                        Go to upload
                        <v-icon name="fa-arrow-right" />
                    </router-link>
                    <p v-else class="text-gray-400">
                        No data
                    </p>
                </div>
            </div>
        </section>
        <section v-if="userData?.role=='admin'" class="flex justify-center items-center gap-2 w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0] ">
            <button class="p-2 rounded text-white text-sm font-bold bg-green-400 hover:bg-green-600">confirm</button>
            <button class="p-2 rounded text-white text-sm font-bold bg-rose-400 hover:bg-rose-600">reject</button>
            <button class="p-2 rounded text-white text-sm font-bold bg-blue-400 hover:bg-blue-600">recompile</button>
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
                request: {
                    id: null,
                    status: '',
                },
                userData: {}
            }
        },
        methods: {
            async getData() {
                const id = this.$route.params.request_id
                await axios.get(`/api/request/show/${id}`)
                .then(response => {
                    console.log(response)
                    const req = response.data?.permit
                    this.request = req
                })
                .catch(error => {
                    console.log(error)
                })
            },
            renderImage(img) {
                return '/storage/app/' + img
            },
            getUserData() {
                const store = useAuthStore()
                this.userData = store.user
            },
            confirmAccept() {
                Swal.fire({
                    title: 'Confirm',
                    text: 'Do you want to continue?',
                    icon: 'question',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonColor: 'red',
                    confirmButtonColor: 'indigo'
                })
                .then(response => {
                    if (response.isConfirmed) {
                        
                    }
                })
            },
            confirmReject() {},
            confirmRecompile() {},
        },
        mounted() {
            this.getData()
            this.getUserData()
        },
    }
</script>