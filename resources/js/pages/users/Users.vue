<template>
    <div class="w-full min-h-screen flex justify-center items-center">
        <section class="w-full md:w-4/5 rounded-lg shadow-xl p-10 bg-[#87e0e0]">
            <header class="mb-5 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Users</h1>
                <input @input="handleSearch" type="text" class="p-2 rounded text-sm text-slate-900 w-1/3" placeholder="Search..." />
            </header>
            <div class="w-full h-80 2xl:h-[500px] overflow-y-auto relative">
                <table class="w-full table-auto md:table-fixed text-center">
                    <thead class="sticky top-0 text-gray-400 bg-slate-900">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Default Password</th>
                            <th>Last Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(u,index) in users" :key="index">
                            <td>
                                <span>{{ u.first_name }}</span>
                                <span>{{ u.middle_name }}</span>
                                <span>{{ u.last_name }}</span>
                                <span>{{ u.extension }}</span>
                            </td>
                            <td>{{ u.role }}</td>
                            <td>{{ u.email }}</td>
                            <td>{{ u.default_password }}</td>
                            <td>{{ u.updated_at }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                users: [],
                usersArr: [],
            }
        },
        methods: {
            getUsers() {
                axios.get('/api/user')
                .then(response => {
                    console.log(response)
                    const u = response.data?.users
                    this.users = u
                    this.usersArr = u
                })
                .catch(error => {
                    console.log(error)
                })
            },
        },
        mounted() {
            this.getUsers()
        },
    }
</script>