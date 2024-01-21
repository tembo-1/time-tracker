<template>
    <div class="relative">
        <label v-if="label" :for="$attrs.id || $attrs.name" class="mb-10 inline-block text-base">{{label}}</label>
        <div class="relative">
            <input v-bind="$attrs" :value="value" :id="$attrs.id || $attrs.name" :type="$attrs.type || 'text'" :class="['inp', icon ? 'pr-90' : 'pr-40']" @input="updateValue" @keyup.enter="onButtonClick" >
            <div class="bg-transparent absolute flex right-0 top-[50%] -translate-y-[50%]" role="group">
                <buttonV v-if="value && !String($attrs.type).includes('date') && !$attrs.hasOwnProperty('readonly')" icon="cross" tabindex="1" class="enabled:hover:text-dark text-gray h-40 w-40 p-[13px]"
                         :disabled="$attrs.disabled" @click="onClean" />
                <buttonV v-if="icon" :icon="icon" class="enabled:hover:text-dark text-gray py-10 px-15"
                         :disabled="$attrs.disabled" @click="onButtonClick" />
            </div>
        </div>
        <span v-if="errors[$attrs.name]" class="text-error absolute bottom-0 translate-y-[100%] left-0 text-xs">{{ errors[$attrs.name][0] }}</span>
    </div>
</template>

<script>
import buttonV from '@/components/buttonV.vue';
import {useAppStore} from "@/stores/AppStore.js";
import {mapState} from "pinia";

export default {
    inheritAttrs: false,
    props: {
        label: String,
        icon: String,
        modelValue: String,
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
        onButtonClick() {
            this.$emit('button-click', this.value);
        },
        onClean() {
            this.value = '';
            this.$emit('update:model-value', '');
            this.$emit('clean');
        }
    },
    computed: {
        ...mapState(useAppStore, {errors: 'ValidationErrors'})
    },
    watch: {
        modelValue(newValue) {
            if (newValue != this.value){
                this.value = newValue
            }
        }
    },
    emits:['update:model-value', 'button-click', 'clean'],
    components: {
        buttonV,
    }
}
</script>
