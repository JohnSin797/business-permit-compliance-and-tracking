<template>
    <div class="w-full min-h-screen flex flex-col md:flex-row justify-center items-center gap-10">
        <section class="w-96 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-2xl font-bold">Account Settings</h1>
            </header>
            <div class="space-y-2">
                <div class="group">
                    <label for="email" class="text-xs text-gray-400 font-bold">Email:</label>
                    <input 
                        type="text" 
                        name="email" 
                        id="email" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.email"
                    />
                </div>
                <div class="group">
                    <label for="password" class="text-xs text-gray-400 font-bold">Password:</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full p-2 text-sm rounded" 
                        
                    />
                </div>
                <button class="text-[8px] text-slate-700 font-bold rounded p-1 bg-cyan-400 hover:bg-cyan-200">change password</button>
                <div class="group">
                    <label for="new_password" class="text-xs text-gray-400 font-bold">New Password:</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
                <div class="group">
                    <label for="new_password" class="text-xs text-gray-400 font-bold">Confirm Password:</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
            </div>
        </section>
        <section class="w-96 rounded-lg shadow-xl p-10 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-2xl font-bold">User Information</h1>
            </header>
            <div class="space-y-2">
                <div class="group">
                    <label for="first_name" class="text-xs text-gray-400 font-bold">First name:</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
                <div class="group">
                    <label for="middle_name" class="text-xs text-gray-400 font-bold">Middle name:</label>
                    <input 
                        type="text" 
                        name="middle_name" 
                        id="middle_name" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
                <div class="group">
                    <label for="last_name" class="text-xs text-gray-400 font-bold">Last name:</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
                <div class="group">
                    <label for="extension" class="text-xs text-gray-400 font-bold">Name extension:</label>
                    <input 
                        type="text" 
                        name="extension" 
                        id="extension" 
                        class="w-full p-2 text-sm rounded" 
                    />
                </div>
                <button class="text-sm text-gray-200 font-bold rounded p-2 bg-blue-600 hover:bg-blue-900">save changes</button>
            </div>
        </section>
    </div>
</template>

<script>
    import { useAuthStore } from '../stores/auth.js'
    export default {
        data() {
            return {
                first_name: '',
                middle_name: '',
                last_name: '',
                extension: '',
                email: '',
            }
        },
        methods: {
            getUser() {
                const store = useAuthStore()
                const user = store.user
                this.first_name = user.first_name
                this.middle_name = user.middle_name
                this.last_name = user.last_name
                this.extension = user.extension
                this.email = user.email
            },
        },
        mounted() {

        },
    }
</script>