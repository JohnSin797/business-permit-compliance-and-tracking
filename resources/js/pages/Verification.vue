<template>
    <div class="flex justify-center items-center min-h-screen">
        <div v-if="loading" class="fixed w-full min-h-screen bg-black flex justify-center items-center">
            <p class="text-2xl text-white font-bold animate-pulse">Loading...</p>
        </div>
        <VerificationForm :handleSubmit="this.handleVerification" />
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import VerificationForm from '../components/VerificationForm.vue';
import { useAuthStore } from '../stores/auth';

    export default {
        data() {
            return {
                loading: false
            }
        },
        components: {
            VerificationForm
        },
        methods: {
            handleVerification(code) {
                const store = useAuthStore()
                this.loading = true
                axios.post('/user/verify-email', { 
                    user_id: store.user.id,
                    verification_code: code 
                })
                .then(response => {
                    store.getUser(response.data?.user)
                    this.$router.push('/')
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'ERROR',
                        text: error.response?.data?.message,
                        icon: 'error',
                    })
                })
                .finally(()=>{
                    this.loading = false
                })
            },
        }
    }
</script>