<template>
    <div class="flex justify-between white-substrate p-0">
        <buttonV icon="chevron-left" class="w-50 px-20 btn-hovered-green rounded-none rounded-l-5"
            @click="changePage(current - 1)" :disabled="current == 1" />
        <swiper-container ref="container" class="h-50" :slides-per-view="pages > shown ? shown : pages" :mousewheel="true" :initial-slide="initialSlide" :style="pages > shown ? `width: ${50 * shown}px` : `width: ${50 * pages}px`">
            <swiper-slide v-for="number in numbersToShow">
                <div role="button" @click="changePage(number)" @keydown.space.enter="changePage(number)" tabindex="1" class="w-full h-full flex justify-center items-center text-base outline-main-green outline-offset-[-1px]" :class="current == number ? 'text-main-green cus-bottom-shadow' : 'hover:bg-main-green hover:text-white'">
                    {{number}}
                </div>
            </swiper-slide>
        </swiper-container>
        <buttonV icon="chevron-right" class="w-50 px-20 btn-hovered-green rounded-none rounded-r-5"
            @click="changePage(current + 1)" :disabled="current == pages" />
    </div>
</template>

<script>
import buttonV from '@/components/buttonV.vue';
import {register} from "swiper/element/bundle";
register();

export default {
    props: {
        pages: Number,
        shown: {
            type: Number,
            default: 8
        },
        current: {
            type: Number,
            default: 1
        }
    },
    methods: {
        scrollToActiveButton() {
            if (this.pages > this.shown){
                const container = this.$refs.container;

                if (container) {
                    container.initialSlide = this.current;
                    container.swiper.slideTo(this.initialSlide)
                }
            }
        },
        changePage(pageNumber) {
            if (pageNumber != this.current) {
                this.$emit('change-page', pageNumber);
            }
        }
    },
    computed: {
        numbersToShow() {
            return [...Array(this.pages).keys()].map(i => i + 1);
        },
        initialSlide() {
            return this.pages > this.shown ? this.current-this.shown/2 : 0
        }
    },
    updated() {
        this.scrollToActiveButton();
    },
    emits: ['change-page'],
    components: {
        buttonV,
    }
}
</script>
