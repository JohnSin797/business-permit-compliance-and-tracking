<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-2xl font-bold">Create Business</h1>
            </header>
            <form @submit.prevent="handleSubmit">
                <div class="mb-2 w-full flex flex-col md:flex-row gap-2">
                    <div class="group w-full md:w-1/2">
                        <label for="business_name" class="text-gray-400 text-xs font-bold">Business Name</label>
                        <input 
                            type="text" 
                            name="business_name" 
                            id="business_name" 
                            class="w-full p-2 rounded text-sm" 
                            placeholder="Business name"
                            v-model="this.business_name"
                            required
                        />
                    </div>
                    <div class="group w-full md:w-1/2">
                        <label for="date_established" class="text-gray-400 text-xs font-bold">Date of Establishment</label>
                        <input 
                            type="date" 
                            name="date_established" 
                            id="date_established" 
                            class="w-full p-2 rounded text-sm" 
                            v-model="this.date_of_establishment"
                            required
                        />
                    </div>
                </div>
                <div class="mb-2 w-full flex flex-col md:flex-row gap-2">
                    <div class="group w-full md:w-1/2">
                        <label for="business_address" class="text-gray-400 text-xs font-bold">Business Address</label>
                        <select
                            name="business_address" 
                            id="business_address" 
                            class="w-full p-2 rounded text-sm" 
                            v-model="this.business_address"
                            required
                        >
                            <option value="">select</option>
                            <option v-for="(brgy, index) in this.barangays" :key="index" :value="brgy">{{ brgy }}</option>
                        </select>
                    </div>
                    <div class="group w-full md:w-1/2">
                        <label for="type_of_organization" class="text-gray-400 text-xs font-bold">Type of Organization</label>
                        <select 
                            name="type_of_organization" 
                            id="type_of_organization" 
                            class="w-full p-2 rounded text-sm"
                            v-model="this.type_of_organization"
                            required
                        >
                            <option value="">select</option>
                            <option value="sole proprietorship">Sole Proprietorship</option>
                            <option value="partnership">Partnership</option>
                            <option value="limited liability company">Limited Liability Company</option>
                            <option value="cooperative">Cooperative</option>
                            <option value="nonprofit corporation">Nonprofit Corporation</option>
                            <option value="benefit corporation">Benefit Corporation</option>
                            <option value="close corporation">Close Corporation</option>
                            <option value="c corporation">C Corporation</option>
                            <option value="s corporation">S Corporation</option>
                        </select>
                    </div>
                </div>
                <div class="mb-2 w-full flex flex-col md:flex-row gap-2">
                    <div class="group w-full md:w-1/2">
                        <label for="dti_registration_number" class="text-gray-400 text-xs font-bold">DTI Registration Number</label>
                        <input 
                            type="text" 
                            name="dti_registration_number" 
                            id="dti_registration_number" 
                            class="w-full p-2 rounded text-sm" 
                            placeholder="DTI Registration Number"
                            v-model="this.dti_registration_number"
                        />
                    </div>
                    <div class="group w-full md:w-1/2">
                        <label for="tin" class="text-gray-400 text-xs font-bold">TIN</label>
                        <input 
                            type="text" 
                            name="tin" 
                            id="tin" 
                            class="w-full p-2 rounded text-sm" 
                            placeholder="TIN"
                            v-model="this.tin"
                        />
                    </div>
                </div>
                    <button 
                        type="submit" 
                        class="rounded p-2 text-sm w-full md:w-1/5 bg-blue-400 hover:bg-blue-600 text-gray-200 hover:text-white font-bold"
                    >
                        Create
                    </button>
            </form>
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
                business_name: '',
                business_address: '',
                date_of_establishment: '',
                type_of_organization: '',
                dti_registration_number: '',
                tin: '',
                barangays: [],
            }
        },
        methods: {
            handleSubmit() {
                const store = useAuthStore()
                axios.post('/business/store', {
                    user_id: store.user.id,
                    business_name: this.business_name,
                    business_address: this.business_address,
                    date_established: this.date_of_establishment,
                    type_of_organization: this.type_of_organization,
                    dti_registration_number: this.dti_registration_number,
                    tin: this.tin,
                })
                .then(response => {
                    this.business_name = ''
                    this.business_address = ''
                    this.date_of_establishment = ''
                    this.type_of_organization = ''
                    this.dti_registration_number = ''
                    this.tin = ''
                    Swal.fire({
                        title: 'Success',
                        text: response.data?.message
                    })
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'Error',
                        text: error.response?.data?.message
                    })
                })
            },
            getBarangays() {
                axios.post('/barangay-list')
                .then(response => {
                    this.barangays = response.data?.barangay
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getBarangays()
        },
    }
</script>