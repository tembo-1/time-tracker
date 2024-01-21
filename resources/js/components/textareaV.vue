<template>
    <div class="relative">
        <label v-if="label" :for="$attrs.id || $attrs.name" class="mb-10 inline-block text-base">{{label}}</label>
        <div class="relative">
            <textarea v-bind="$attrs" :id="$attrs.id || $attrs.name" class="inp pr-40" @input="updateValue" :value="value"></textarea>
            <div class="bg-transparent absolute flex right-0 top-0" role="group">
                <buttonV v-if="value" icon="cross" tabindex="1" class="enabled:hover:text-dark text-gray h-40 w-40 p-[13px]"
                         :disabled="$attrs.disabled" @click="onClean" />
            </div>

        </div>
        <span v-if="errors[$attrs.name]" class="text-error absolute bottom-0 translate-y-[50%] left-0 text-xs">{{ errors[$attrs.name][0] }}</span>
    </div>
</template>

<script>
import buttonV from '@/components/buttonV.vue';
import {mapState} from "pinia";
import {useAppStore} from "@/stores/AppStore.js";

export default {
    inheritAttrs: false,
    props: {
        label: String,
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
        onClean(){
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
            if (newValue != this.value && newValue != undefined){
                this.value = newValue
            }
        }
    },
    emits:['update:model-value', 'clean'],
    components: {
        buttonV,
    }
}
</script>



