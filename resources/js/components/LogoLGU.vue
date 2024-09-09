<template>
    <div :class="sizeClass">
        <img src="/public/asset/images/lgu-logo.jpg" alt="lgu-logo" class="w-full h-full">
    </div>
</template>

<script>
    export default {
        props: {
            sizeClass: {
                type: String,
                required: false
            }
        }
    }
</script>