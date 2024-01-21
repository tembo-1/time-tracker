<template>
    <div class="flex w-fit items-center rounded-5" role="group">
        <buttonV @click="updateCount(count-1)" class="w-40 h-40 p-0 border border-gray border-r-0 rounded-r-none btn-hovered-green" text="−" />
        <input @change="updateCount(Number($refs.input.value))" @input="calculateWidth" ref="input" type="number" :value="count" class="h-40 border-x-0 border-gray focus:border-gray focus:ring-0 text-center p-0 bg-transparent appearance-none" :style="`width: ${20 + String(count).length * 10}px`">
        <buttonV @click="updateCount(count+1)" class="w-40 h-40 p-0 border border-gray border-l-0 rounded-l-none btn-hovered-green" text="+" />
    </div>
</template>

<script>
import buttonV from "@/components/buttonV.vue";
import {debounce} from "@/helpers/Debounce.js";
export default {
    name: "Counter",
    props: {
        initialValue: {
            type: Number,
            default: 1
        }
    },
    data() {
        return {
            count: this.initialValue,
            emitUpdate: debounce(() => this.$emit('count-updated', this.count)),
        };
    },
    methods: {
        updateCount(newValue) {
            if(newValue != this.count) {
                if (newValue < 1) {
                    this.$refs.input.value = this.count;
                    this.$emit('count-invalid');
                } else {
                    this.count = newValue;
                    this.emitUpdate();
                }
                this.calculateWidth();
            }
        },
        calculateWidth() {
            this.$refs.input.style.width = 20 + String(this.$refs.input.value).length * 10 + 'px';
        }
    },
    watch: {
        initialValue(newValue) {
            if (newValue !== this.count) {
                this.count = newValue
            }
        },
    },
    components: {
        buttonV,
    },
    emits: ['count-updated', 'count-invalid'],
};
</script>

