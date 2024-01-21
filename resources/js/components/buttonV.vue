<template>
    <button type="button" class="btn">
        <iconV v-if="icon" :name="icon" :class="iconClasses"/>
        {{ text }}
    </button>
</template>

<script>
import iconV from '@/components/iconV.vue';
export default {
    props: {
        text: [String, Number],
        icon: String,
        iconClasses: String,
    },
    components: {
        iconV
    }
}
</script>
