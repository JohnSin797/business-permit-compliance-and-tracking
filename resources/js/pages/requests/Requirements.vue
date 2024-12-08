<template>
    <div class="w-full min-h-screen flex justify-center items-center pt-20">
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="flex justify-start items-start gap-2">
                <router-link to="/request" class="block p-2 rounded text-white bg-blue-400 hover:bg-blue-600">
                    <v-icon name="fa-arrow-left" />
                </router-link>
                <header class="mb-5 text-gray-900">
                    <h1 class="text-2xl font-bold">Requirements</h1>
                    <p class="text-sm">Take a picture of your completed requirements and upload them</p>
                </header>
            </header>
            <form enctype="multipart/form-data">
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">Barangay Clearance</p>
                        <div v-if="this.requirements?.barangay_clearance" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="barangay_clearance" class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="barangay_clearance" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="barangay_clearance" 
                            id="barangay_clearance" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">Cedula</p>
                        <div v-if="this.requirements?.cedula" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="cedula"class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="cedula" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="cedula" 
                            id="cedula" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">Business Registration</p>
                        <div v-if="this.requirements?.business_registration" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="business_registration"class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="business_registration" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="business_registration" 
                            id="business_registration" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">BIR Certificate of Registration</p>
                        <div v-if="this.requirements?.bir_certificate_of_registration" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="bir_certificate_of_registration"class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="bir_certificate_of_registration" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="bir_certificate_of_registration" 
                            id="bir_certificate_of_registration" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">Notarized Contract of Lease (if user is lessee / sharing office)</p>
                        <div v-if="this.requirements?.notarized_contract_of_lease" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="notarized_contract_of_lease"class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="notarized_contract_of_lease" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="notarized_contract_of_lease" 
                            id="notarized_contract_of_lease" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
                <div class="w-full space-y-2 text-gray-900">
                    <div class="flex justify-between items-center border-b py-2">
                        <p class="font-bold">ECC or CNC (if applicable DENR)</p>
                        <div v-if="this.requirements?.ecc_cnc_denr" class="flex justify-center items-center gap-2">
                            <p class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                            </p>
                            <label for="ecc_cnc_denr"class="block rounded-full bg-indigo-400 hover:bg-indigo-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                                <v-icon name="fa-pencil-alt" class="text-gray-200" />
                            </label>
                        </div>
                        <label v-else for="ecc_cnc_denr" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="ecc_cnc_denr" 
                            id="ecc_cnc_denr" 
                            class="hidden"
                            @change="handleUpload" 
                        />
                    </div>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
    import axios from 'axios'
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                requirements: {
                    id: null,
                    application_form: null,
                    barangay_clearance: null,
                    cedula: null,
                    business_registration: null,
                    bir_certificate_of_registration: null,
                    notarized_contract_of_lease: null,
                    ecc_cnc_denr: null,
                }
            }
        },
        methods: {
            handleUpload(event) {
                console.log('asd')
                const file = event.target.files[0]
                const column = event.target.name
                this.uploadFile(column, file)
            },
            uploadFile(column, file) {
                const id = this.$route.params.requirement_id
                const formData = new FormData()
                formData.append('column', column?.toString())
                formData.append('value', file)
                formData.append('id', id)
                axios.post('/requirements', formData)
                .then(response => {
                    console.log(response)
                    this.requirements = response.data?.requirement
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'Upload Error',
                        text: error.response?.data?.message,
                        icon: 'error'
                    })
                })
            },
            getRequirements() {
                const id = this.$route.params.requirement_id
                axios.post('/requirements/index', { id: id })
                .then(response => {
                    this.requirements = response.data?.requirement
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.getRequirements()
        }
    }
</script>