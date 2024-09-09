<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-96 rounded-lg shadow-xl p-10 border border-black">
            <p class="text-sm text-center font-bold mb-2">Sign in</p>
            <header class="mb-2 flex items-center justify-center gap-2">
                <LogoLGU sizeClass="w-12 h-12" />
                <h1 class="text-xs text-gray-700 font-bold">Business Permit Compliance & Tracking</h1>
            </header>
            <form @submit.prevent="handleSignIn">
                <div class="w-full space-y-2">
                    <div class="group">
                        <label for="email" class="text-xs font-bold">Email:</label>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            class="w-full border border-black p-2 rounded" 
                            required 
                            v-model="this.email"
                        />
                    </div>
                    <div class="group">
                        <label for="password" class="text-xs font-bold">Password:</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="w-full border border-black p-2 rounded" 
                            required 
                            v-model="this.password"
                        />
                    </div>
                    <button type="submit" class="w-full rounded p-2 text-sm text-white font-bold bg-blue-400 hover:bg-blue-600">Sign in</button>
                    <p class="text-xs text-center">
                        No account yet?
                        <router-link to="/sign-up" class="text-blue-600 hover:text-blue-900 font-bold">Sign up</router-link>
                    </p>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import LogoLGU from '../../components/LogoLGU.vue';
    import { useAuthStore } from '../../stores/auth';
    import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                email: '',
                password: '',
            }
        },
        components: {
            LogoLGU
        },
        methods: {
            handleSignIn() {
                axios.post('/api/user/login', {
                    email: this.email,
                    password: this.password,
                })
                .then(response => {
                    const store = useAuthStore()
                    store.getToken(response.data?.token)
                    store.getUser(response.data?.user)
                    this.$router.push('/')
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'Error',
                        text: error?.response?.data?.error,
                        icon: 'error'
                    })
                })
            }
        }
    }
</script>