<template>
    <div :class="shellClasses">
        <div class="relative">
            <div class="flex gap-x-10">
                <input v-bind="$attrs" :id="$attrs.id || $attrs.name" :checked="checked" @change="updateValue" type="checkbox" class="text-main-green inp w-20 h-20 p-0 enabled:cursor-pointer border-gray peer" :style="{ marginTop: checkboxMargin + 'px' }">
                <label v-if="label" ref="label" :for="$attrs.id || $attrs.name" class="peer-disabled:opacity-50" :class="{'peer-enabled:cursor-pointer' : $attrs.id || $attrs.name}">{{ label }}</label>
            </div>
            <span v-if="errors[$attrs.name]" class="text-error absolute bottom-0 translate-y-[100%] left-30 text-xs">{{ errors[$attrs.name][0] }}</span>
        </div>
    </div>
</template>

<script>
import {mapState} from "pinia";
import {useAppStore} from "@/stores/AppStore.js";

export default {
    inheritAttrs: false,
    props: {
        label: String,
        shellClasses: String,
        modelValue: Boolean,
    },
    data() {
        return {
            checked: this.modelValue || this.$attrs.checked || false,
            checkboxMargin: 0
        }
    },
    methods: {
        updateValue(event) {
            this.checked = event.target.checked;
            this.$emit('update:model-value', event.target.checked);
            this.$emit('change');
        },
        updateCheckboxMargin() {
            if (this.label) {
                // Получение line-height из стиля label
                const labelStyle = getComputedStyle(this.$refs.label);
                const lineHeight = parseInt(labelStyle.lineHeight);

                // Установка отступа для чекбокса
                this.checkboxMargin = Math.max(lineHeight / 2 - 10, 0); // 10 - половина высоты чекбокса
            }
        },
    },
    computed: {
        ...mapState(useAppStore, {errors: 'ValidationErrors'})
    },
    watch: {
        modelValue(newValue) {
            if (newValue != this.checked){
                this.checked = Boolean(newValue);
            }
        }
    },
    mounted() {
        this.updateCheckboxMargin();
    },
    emits:['update:model-value', 'change'],
}
</script>
