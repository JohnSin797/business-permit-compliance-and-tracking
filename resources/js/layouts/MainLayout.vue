<template>
    <main class="w-full h-full">
        <Navigation />
        <TopNav />
        <div class="w-full md:w-5/6 min-h-screen bg-[#87e0e0] absolute top-0 right-0">
            <slot></slot>
        </div>
    </main>
</template>

<script>
    import Navigation from '../components/Navigation.vue';
    import TopNav from '../components/TopNav.vue';

    export default {
        components: {
            Navigation, TopNav
        }
    }
</script>