<template>
    <div class="flex flex-col relative">
        <label v-if="label" :for="$attrs.id || $attrs.name" class="mb-10 inline-block text-base">{{label}}</label>
        <select v-bind="$attrs" :id="$attrs.id || $attrs.name" :value="value" @change="updateValue" class="inp disabled:cursor-default">
            <slot></slot>
        </select>
        <span v-if="errors[$attrs.name]" class="text-error absolute bottom-0 translate-y-[100%] left-0 text-xs">{{ errors[$attrs.name][0] }}</span>
    </div>
</template>

<script>
import {mapState} from "pinia";
import {useAppStore} from "@/stores/AppStore.js";

export default {
    inheritAttrs: false,
    props: {
        label: String,
        modelValue: [String, Number],
    },
    data() {
        return {
            value: this.modelValue || this.$attrs.value || '',
        }
    },
    methods: {
        updateValue(event) {
            this.value = event.target.value;
            this.$emit('update:model-value', event.target.value);
        },
    },
    computed: {
        ...mapState(useAppStore, {errors: 'ValidationErrors'})
    },
    watch: {
        modelValue(newValue) {
            if (newValue != this.value && newValue != undefined){
                this.value = newValue
            }
        }
    },
    emits:['update:model-value'],
}
</script>

<style>
select:not([size]) {
    background-image: url('/img/chevron-down.svg');
    background-position: right 0.938rem center;
    background-repeat: no-repeat;
    background-size: 0.9em 0.9em;
    padding-right: 2.188rem;
    appearance: none;
    cursor: pointer;
}
</style>
