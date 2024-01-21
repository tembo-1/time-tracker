<template>
    <TransitionGroup name="slide-fade">
        <section v-bind="$attrs" v-for="stepNumber in steps" v-show="step === stepNumber" :key="stepNumber">
            <slot :name="`step${stepNumber}`">
            </slot>
        </section>
    </TransitionGroup>
    <slot name="buttons" :previousStep="previousStep" :nextStep="nextStep" :steps="steps" :step="step">
        <div class="grid grid-cols-3 gap-x-20 w-full">
            <buttonV class="btn-white-bordered col-span-1" text="Назад" v-if="step > 1" @click="previousStep"/>
            <buttonV class="btn-white-bordered col-start-3" text="Далее" v-if="step < steps" @click="nextStep"/>
            <buttonV class="btn-green col-start-3" text="Готово" v-if="step === steps"/>
        </div>
    </slot>
</template>

<script>
import buttonV from "@/components/buttonV.vue";

export default {
    inheritAttrs: false,
    data() {
        return {
            step: 1,
            steps: Object.keys(this.$slots).filter(slot => slot.includes('step')).length
        };
    },
    methods: {
        previousStep() {
            this.step-1 ? this.step-- : false;
        },

        nextStep() {
            this.step < this.steps ? this.step++ : false;
        },
    },
    components: {buttonV},

};
</script>

<style scoped>
.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    display: none;
    transition: all .4s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter-from, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
