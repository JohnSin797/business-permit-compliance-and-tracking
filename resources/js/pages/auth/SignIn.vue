<template>
    <div class="w-full min-h-screen flex justify-center items-center bg-guest">
        <section class="w-96 rounded-lg shadow-xl p-10 border border-cyan-400 backdrop-blur-md">
            <p class="text-xl text-center text-gray-100 font-bold mb-2">Sign in</p>
            <header class="mb-2 flex items-center justify-center gap-2">
                <div class="w-12 min-w-12 h-12 rounded-full overflow-hidden">
                    <LogoLGU sizeClass="w-12 h-12" />
                </div>
                <h1 class="text-xs text-gray-100 font-bold">Business Permit Compliance & Tracking</h1>
            </header>
            <form @submit.prevent="handleSignIn">
                <div class="w-full space-y-2">
                    <div class="group">
                        <label for="email" class="text-xs text-gray-300 font-bold">Email:</label>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            class="w-full border border-black p-2 rounded" 
                            placeholder="Email"
                            required 
                            v-model="this.email"
                        />
                    </div>
                    <div class="group">
                        <label for="password" class="text-xs text-gray-300 font-bold">Password:</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="w-full border border-black p-2 rounded" 
                            placeholder="password"
                            required 
                            v-model="this.password"
                        />
                    </div>
                    <button type="submit" class="w-full rounded p-2 text-sm text-white font-bold bg-blue-400 hover:bg-blue-600">Sign in</button>
                    <p class="text-xs text-gray-100 text-center">
                        No account yet?
                        <router-link to="/sign-up" class="text-blue-300 hover:text-blue-400 font-bold">Sign up</router-link>
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
                    const user = response.data?.user
                    store.getToken(response.data?.token)
                    store.getUser(user)
                    store.setProfileImage(user.profile_image??'/asset/images/default-profile-img.jpg')
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