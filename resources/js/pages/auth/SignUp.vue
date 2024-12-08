<template>
    <div class="w-full min-h-screen flex justify-center items-center bg-guest">
        <section class="w-96 md:w-3/5 rounded-lg shadow-xl p-10 border border-cyan-400 backdrop-blur-md">
            <p class="text-xl text-center text-gray-100 font-bold mb-2">Sign up</p>
            <header class="mb-2 flex items-center justify-center gap-2">
                <div class="w-12 min-w-12 h-12 rounded-full overflow-hidden">
                    <LogoLGU sizeClass="w-12 h-12" />
                </div>
                <h1 class="text-xs text-gray-100 font-bold">Business Permit Compliance & Tracking</h1>
            </header>
            <form @submit.prevent="handleSignUp">
                <div class="flex flex-col md:flex-row gap-2 items-center w-full">
                    <div class="space-y-2 w-full md:w-1/2">
                        <h1 class="text-xs text-gray-300 font-bold">User Information</h1>
                        <input 
                            type="text" 
                            name="first_name" 
                            id="first_name" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="First name"
                            v-model="this.first_name"
                            required
                        />
                        <input 
                            type="text" 
                            name="middle_name" 
                            id="middle_name" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Middle name"
                            v-model="this.middle_name"
                            required
                        />
                        <input 
                            type="text" 
                            name="last_name" 
                            id="last_name" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Last name"
                            v-model="this.last_name"
                            required
                        />
                        <input 
                            type="text" 
                            name="extension" 
                            id="extension" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Name extension"
                            v-model="this.extension"
                        />
                    </div>
                    <div class="space-y-2 w-full md:w-1/2">
                        <h1 class="text-xs text-gray-300 font-bold">Account Settings</h1>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Email"
                            v-model="this.email"
                            required
                        />
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Password"
                            v-model="this.password"
                            required
                        />
                        <input 
                            type="password" 
                            name="confirm_password" 
                            id="confirm_password" 
                            class="w-full p-2 rounded text-sm border border-gray-600 placeholder:text-gray-700" 
                            placeholder="Confirm Password"
                            v-model="this.confirm_password"
                            required
                        />
                        <div class="flex gap-2 items-center">
                            <button type="submit" class="w-1/3 p-2 rounded text-sm bg-blue-400 hover:bg-blue-600 text-white font-bold">Sign up</button>
                            <p class="text-xs text-gray-300 text-center">
                                Already have an account? 
                                <router-link to="/sign-in" class="text-blue-300 hover:text-blue-400 font-bold">Sign in</router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import LogoLGU from '../../components/LogoLGU.vue';
import { useAuthStore } from '../../stores/auth';

    export default {
        data() {
            return {
                first_name: '',
                middle_name: '',
                last_name: '',
                extension: '',
                email: '',
                password: '',
                confirm_password: '',
            }
        },
        components: {
            LogoLGU
        },
        methods: {
            handleSignUp() {
                const store = useAuthStore()
                axios.post('/api/user/register', {
                    first_name: this.first_name,
                    middle_name: this.middle_name,
                    last_name: this.last_name,
                    extension: this.extension,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.confirm_password,
                })
                .then(response => {
                    store.getToken(response.data?.token)
                    store.getUser(response.data?.user)
                    this.$router.push('/')
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>