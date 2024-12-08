<template>
    <div class="fixed w-full md:w-1/6 min-h-screen p-5 bg-[#87e0e0]">
        <header class="mb-5 flex flex-col items-center gap-2">
            <div class="w-14 h-14 rounded-full overflow-hidden">
                <LogoLGU sizeClass="w-14 h-14" />
            </div>
            <h1 class="text-sm text-gray-900 text-center font-bold">Business Permit Compliance & Tracking</h1>
        </header>
        <nav class="flex flex-col gap-2 font-bold text-slate-700">
            <router-link to="/" class="p-2 rounded" :class="{'bg-slate-600 text-white' : this.isLinkActive('/')}">
                <v-icon name="md-dashboard-round" />
                Dashboard
            </router-link>
            <router-link to="/business" class="p-2 rounded" :class="{'bg-slate-600 text-white' : this.isLinkActive('/business')}">
                <v-icon name="md-business-round" />
                Business
            </router-link>
            <router-link to="/request" class="p-2 rounded" :class="{'bg-slate-600 text-white' : this.isLinkActive('/request')}">
                <v-icon name="md-confirmationnumber-round" />
                Request
            </router-link>
            <router-link to="/profile" class="p-2 rounded" :class="{'bg-slate-600 text-white' : this.isLinkActive('/profile')}">
                <v-icon name="md-personpin-round" />
                Profile
            </router-link>
            <button class="p-2 rounded text-left" @click="logout">logout</button>
        </nav>
    </div>
</template>

<script>
    import { useAuthStore } from '../stores/auth';
    import LogoLGU from './LogoLGU.vue';

    export default {
        components: {
            LogoLGU
        },
        methods: {
            logout() {
                const store = useAuthStore()
                store.logout()
                this.$router.push('/sign-in')
            },
            isLinkActive(link) {
                if (link === '/') {
                    return link == this.$route.path
                }

                return this.$route.path.startsWith(link)
            }
        }
    }
</script>