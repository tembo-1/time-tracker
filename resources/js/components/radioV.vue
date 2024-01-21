<template>
    <div>
        <div class="flex items-center gap-x-10">
            <input v-bind="$attrs" type="radio" class="inp w-20 h-20 text-transparent checked:border-5 checked:border-main-green p-0 rounded-full enabled:cursor-pointer border-gray peer">
            <label :for="$attrs.id" class="peer-disabled:opacity-50 peer-enabled:cursor-pointer">{{ label }}</label>
        </div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        label: String,
    },
}
</script>

