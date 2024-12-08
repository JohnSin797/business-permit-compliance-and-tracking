<template>
    <div class="w-96 rounded-lg shadow-xl p-10 bg-blue-400">
        <header class="mb-5">
            <h1 class="text-2xl font-bold text-slate-900">Verify email</h1>
        </header>
        <form @submit.prevent="handleVerification">
            <div class="w-full space-y-2">
                <input 
                    type="text" 
                    name="" 
                    id="" 
                    class="w-full p-2 rounded"
                    placeholder="Enter verification code here..." 
                    v-model="this.verification_code"
                />
                <button type="submit" class="w-full p-2 rounded bg-green-300 hover:bg-green-400 text-white font-bold">enter</button>
                <button type="button" @click="resendCode" class="w-full p-2 rounded bg-yellow-300 hover:bg-yellow-400 text-white font-bold">resend code</button>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import { useAuthStore } from '../stores/auth';

    export default {
        props: {
            handleSubmit: {
                type: Function,
                required: true,
            }
        },
        data() {
            return {
                verification_code: '',
            }
        },
        computed: {
            handleVerification() {
                this.handleSubmit(this.verification_code)
            },
        },
        methods: {
            resendCode() {
                const store = useAuthStore()
                axios.post('/user/resend', {
                    user_id: store.user.id
                })
                .then(response => {
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>