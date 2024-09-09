<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-3/5 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-2xl font-bold">Requirements</h1>
                <p class="text-sm">Take a picture of your completed requirements and upload them</p>
            </header>
            <form enctype="multipart/form-data">
                <div class="w-full space-y-2 text-gray-400">
                    <div class="flex justify-between items-center border-b pb-2">
                        <p class="font-bold">Application form</p>
                        <p v-if="this.requirements.application_form" class="block rounded-full bg-green-400 w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-regular-check-circle" class="text-gray-200" scale="1.9" />
                        </p>
                        <label v-else for="application_form" class="block rounded-full bg-blue-400 hover:bg-blue-600 cursor-pointer w-8 h-8 flex justify-center items-center">
                            <v-icon name="fa-upload" class="text-gray-200" />
                        </label>
                        <input 
                            type="file" 
                            name="application_form" 
                            id="application_form" 
                            class="hidden"
                            @change="handleUpload" 
                            :disabled="this.requirements.application_form != null"
                        />
                    </div>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                requirements: {}
            }
        },
        methods: {
            handleUpload(event) {
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
                    this.requirements = response.data?.requirements
                })
                .catch(error => {
                    console.log(error)
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