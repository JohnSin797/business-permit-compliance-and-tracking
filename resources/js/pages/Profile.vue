<template>
    <div class="w-full min-h-screen flex flex-col justify-center items-center gap-10 py-20">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-2xl font-bold">User Information</h1>
            </header>
            <div class="mb-5 flex flex-col justify-center items-center w-60">
                <div class="w-52 h-52 rounded-full overflow-hidden bg-gray-400 flex justify-center items-center ring-2 ring-cyan-400">
                    <img :src="profile_image" alt="profile-image" class="" />
                </div>
                <input @change="changeProfileImage" accept="image/jpeg, image/jpg" type="file" class="hidden" name="profile-image" id="profile-image" />
                <label for="profile-image" class="block mt-2 p-1 rounded text-xs text-white cursor-pointer bg-teal-600 hover:bg-teal-900">change profile image</label>
            </div>
            <div class="flex justify-center items-center gap-2 mb-2">
                <div class="group w-full md:w-1/3">
                    <label for="first_name" class="text-xs text-gray-900 font-bold">First name:</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.first_name"
                        v-on:keypress="isLetter"
                    />
                    <p class="block h-4 text-xs text-red-400">{{ this.errors.first_name }}</p>
                </div>
                <div class="group w-full md:w-1/3">
                    <label for="middle_name" class="text-xs text-gray-900 font-bold">Middle name:</label>
                    <input 
                        type="text" 
                        name="middle_name" 
                        id="middle_name" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.middle_name"
                        v-on:keypress="isLetter"
                    />
                    <p class="block h-4 text-xs text-red-400">{{ this.errors.middle_name }}</p>
                </div>
                <div class="group w-full md:w-1/3">
                    <label for="last_name" class="text-xs text-gray-900 font-bold">Last name:</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.last_name"
                        v-on:keypress="isLetter"
                    />
                    <p class="block h-4 text-xs text-red-400">{{ this.errors.last_name }}</p>
                </div>
                <div class="group w-full md:w-1/6">
                    <label for="extension" class="text-xs text-gray-900 font-bold">Name extension:</label>
                    <input 
                        type="text" 
                        name="extension" 
                        id="extension" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.extension"
                        v-on:keypress="isLetter"
                    />
                    <p class="block h-4"></p>
                </div>
            </div>
            <button @click.prevent="validateUser" class="w-1/6 text-sm text-gray-200 font-bold rounded p-2 bg-blue-600 hover:bg-blue-900">save</button>
        </section>
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 text-gray-900">
                <h1 class="text-2xl font-bold">Account Settings</h1>
            </header>
            <div class="flex justify-center items-center gap-2 mb-2">
                <div class="group w-full md:w-1/2">
                    <label for="email" class="text-xs text-gray-900 font-bold">Email:</label>
                    <input 
                        type="text" 
                        name="email" 
                        id="email" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.email"
                    />
                    <p class="block h-4 text-xs text-red-400">{{ this.errors.email }}</p>
                </div>
                <div class="group w-full md:w-1/2">
                    <label for="password" class="text-xs text-gray-900 font-bold">Password:</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full p-2 text-sm rounded" 
                        v-model="this.old_password"
                    />
                    <p class="block h-4 text-xs text-red-400">{{ this.errors.old_password }}</p>
                </div>
            </div>
            <div class="flex flex-col">
                <button @click="changePassword" class="mb-2 w-1/6 text-xs text-white p-1 rounded bg-gray-600 hover:bg-gray-700">change password</button>
                <div v-if="password_change" class="flex justify-center items-center gap-2 mb-2">
                    <div class="group w-full md:w-1/2">
                        <label for="new_password" class="text-xs text-gray-900 font-bold">New Password:</label>
                        <input 
                            type="password" 
                            name="new_password" 
                            id="new_password" 
                            class="w-full p-2 text-sm rounded" 
                            v-model="this.password"
                        />
                        <p class="block h-4 text-xs text-red-400">{{ this.errors.password }}</p>
                    </div>
                    <div class="group w-full md:w-1/2">
                        <label for="password_confirmation" class="text-xs text-gray-900 font-bold">Confirm Password:</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="w-full p-2 text-sm rounded" 
                            v-model="this.password_confirmation"
                        />
                        <p class="block h-4 text-xs text-red-400">{{ this.errors.password_confirmation }}</p>
                    </div>
                </div>
                <button @click.prevent="validateAccount" class="w-1/6 text-sm text-gray-200 font-bold rounded p-2 bg-blue-600 hover:bg-blue-900">save</button>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
import { useAuthStore } from '../stores/auth.js'
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                first_name: '',
                middle_name: '',
                last_name: '',
                extension: '',
                profile_image: '',
                email: '',
                old_password: '',
                password: '',
                password_confirmation: '',
                password_change: false,
                errors: {},
            }
        },
        methods: {
            changeProfileImage(e) {
                const store = useAuthStore()
                const profileImage = e.target.files[0]
                axios.post('/api/user/profile-image', { user_id: store.user.id, profile_image: profileImage }, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then(response => {
                    console.log(response)
                    const img = response.data?.profile_image
                    this.profile_image = img
                    store.setProfileImage(img)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            isLetter(e) {
                let char = String.fromCharCode(e.keyCode); // Get the character
                if(/^[A-Za-z]+$/.test(char)) return true; // Match with regex 
                else e.preventDefault(); // If not match, don't add to input text
            },
            getUser() {
                const store = useAuthStore()
                const user = store.user
                this.first_name = user.first_name
                this.middle_name = user.middle_name
                this.last_name = user.last_name
                this.extension = user.extension
                this.email = user.email
                this.profile_image = store.profileImage
            },
            changePassword() {
                this.password_change = !this.password_change
            },
            updateAccount() {
                const store = useAuthStore()
                axios.post('/user/update/account', {
                    user_id: store.user.id,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(response => {
                    store.getUser(response.data?.user)
                    this.email = response.data?.user?.email
                    Swal.fire({
                        title: 'Success',
                        text: 'Account Settings successfully updated',
                        icon: 'success'
                    })
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire({
                        title: 'Error',
                        text: error.response?.data?.message,
                        icon: 'error'
                    })
                })
            },
            updateUser() {
                const store = useAuthStore()
                axios.post('/user/update/user', {
                    id: store.user.id,
                    first_name: this.first_name,
                    middle_name: this.middle_name,
                    last_name: this.last_name,
                    extension: this.extension,
                })
                .then(response => {
                    const user = response.data?.user
                    store.getUser(user)
                    this.first_name = user.first_name
                    this.middle_name = user.middle_name
                    this.last_name = user.last_name
                    this.extension = user.extension
                    Swal.fire({
                        title: 'Success',
                        text: 'User Information successfully updated',
                        icon: 'success',
                    })
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: error.response?.data?.message
                    })
                })
            },
            validateAccount() {
                this.errors = {}

                if (!this.email) {
                    this.errors.email = 'Email is required'
                }

                if (this.password_change && !this.old_password) {
                    this.errors.old_password = 'Old password is required'
                }

                if (this.password_change && !this.password) {
                    this.errors.password = 'New password is required'
                }

                if (this.password_change && !this.password_confirmation) {
                    this.errors.password_confirmation = 'Password confirmation is required'
                }

                if (this.password_change && this.password != this.password_confirmation) {
                    this.errors.password = 'Password mismatch'
                    this.errors.password_confirmation = 'Password mismatch'
                }

                if (Object.keys(this.errors).length === 0) {
                    this.updateAccount()
                } 
            },
            validateUser() {
                this.errors = {}

                if (!this.first_name) {
                    this.errors.first_name = 'First name is required'
                }
                
                if (!this.middle_name) {
                    this.errors.middle_name = 'Middle name is required'
                }
                
                if (!this.last_name) {
                    this.errors.last_name = 'Last name is required'
                }

                if (Object.keys(this.errors).length === 0) {
                    this.updateUser()
                }
            },
        },
        mounted() {
            this.getUser()
        },
    }
</script>