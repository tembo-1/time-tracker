<template>
    <span class="block w-15 h-15 text-xs text-center text-white bg-main-green rounded-full">{{ value < 10 ? value : 'м' }}</span>
</template>


<script>
export default {
    name: "badge",
    props: {
        value: Number,
    }
}
</script>
