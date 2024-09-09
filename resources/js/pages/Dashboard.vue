<template>
    <div class="w-full min-h-screen flex flex-col justify-center items-center">
        <VerificationForm v-if="isVerified" :handleSubmit="this.handleVerification" />
        <RequestWindow />
    </div>
</template>

<script>
    import axios from 'axios';
    import VerificationForm from '../components/VerificationForm.vue';
    import { useAuthStore } from '../stores/auth';
    import RequestWindow from '../components/RequestWindow.vue';

    export default {
        data() {
            return {
                isVerified: false,
            }
        },
        components: {
            VerificationForm, RequestWindow
        },
        methods: {
            handleVerification(code) {
                const store = useAuthStore()
                axios.post('/user/verify-email', { 
                    user_id: store.user.id,
                    verification_code: code 
                })
                .then(response => {
                    store.getUser(response.data?.user)
                    this.checkIfVerified
                })
                .catch(error => {
                    console.log(error)
                })
            },
            checkIfVerified() {
                const store = useAuthStore()
                const verified = store.user?.email_verified_at
                this.isVerified = verified == null
            },
        },
        computed: {

        },
        mounted() {
            this.checkIfVerified()
        }
    }
</script>