<template>
    <div>
        <div class="flex items-center" :class="type == 'success' ? 'text-main-green' : type == 'error' ? 'text-error' : ''">
            <iconV v-if="icon" :name="icon" class="mr-10" />
            <p class="text-xl font-semibold mr-10">{{title}}</p>
            <iconV name="cross" role="button" class="text-gray ml-auto hover:text-dark" />
        </div>
        <p v-if="text" class="break-words mt-10">{{text}}</p>
    </div>
</template>

<script>
import iconV from "@/components/iconV.vue";

export default {
    name: "Toast",
    props: {
        title: {
            type: String,
            required: true
        },
        text: String,
        icon: String,
        type: {
            type: String,
            default: 'default',
            validator(value) {
                return ['default' ,'success', 'error'].includes(value)
            }
        }
    },
    components: {iconV},
}
</script>
