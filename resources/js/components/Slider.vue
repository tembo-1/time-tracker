<template>
    <div id="default-carousel" class="relative w-full">
        <!-- Carousel wrapper -->
        <div class="relative overflow-hidden h-[800px]">
            <!-- Item 1 -->
            <div id="carousel-item-1" class="hidden duration-500 ease-in-out">
                <img src="/mocks/slide.jpg" class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div id="carousel-item-2" class="hidden duration-500 ease-in-out">
                <img src="https://flowbite.com/docs/images/carousel/carousel-2.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div id="carousel-item-3" class="hidden duration-500 ease-in-out">
                <img src="https://flowbite.com/docs/images/carousel/carousel-3.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div id="carousel-item-4" class="hidden duration-500 ease-in-out">
                <img src="https://flowbite.com/docs/images/carousel/carousel-4.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-20 left-1/2">
            <button tabindex="-1" id="carousel-indicator-1" type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"></button>
            <button tabindex="-1" id="carousel-indicator-2" type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"></button>
            <button tabindex="-1" id="carousel-indicator-3" type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"></button>
            <button tabindex="-1" id="carousel-indicator-4" type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"></button>
        </div>
        <!-- Slider controls -->
        <button id="data-carousel-prev" type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group">
            <span class="inline-flex items-center justify-center w-40 h-40 rounded-full">
                <svg class="w-15 h-15 text-main-green group-hover:text-main-light-green duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button id="data-carousel-next" type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group">
            <span class="inline-flex items-center justify-center w-40 h-40 rounded-full">
                <svg class="w-15 h-15 text-main-green group-hover:text-main-light-green duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</template>

<script>
import { Carousel } from 'flowbite';

export default {
    mounted() {
        const items = [
            {
                position: 0,
                el: document.getElementById('carousel-item-1')
            },
            {
                position: 1,
                el: document.getElementById('carousel-item-2')
            },
            {
                position: 2,
                el: document.getElementById('carousel-item-3')
            },
            {
                position: 3,
                el: document.getElementById('carousel-item-4')
            },
        ];

        const options = {
            defaultPosition: 0,
            interval: 5000,
            indicators: {
                activeClasses: 'bg-main-green',
                inactiveClasses: 'bg-white/50 hover:bg-white/30 shadow',
                items: [
                    {
                        position: 0,
                        el: document.getElementById('carousel-indicator-1')
                    },
                    {
                        position: 1,
                        el: document.getElementById('carousel-indicator-2')
                    },
                    {
                        position: 2,
                        el: document.getElementById('carousel-indicator-3')
                    },
                    {
                        position: 3,
                        el: document.getElementById('carousel-indicator-4')
                    },
                ]
            },
        };
        const carousel = new Carousel(items, options);

        const $prevButton = document.getElementById('data-carousel-prev');
        const $nextButton = document.getElementById('data-carousel-next');

        $prevButton.addEventListener('click', () => {
            carousel.prev();
        });

        $nextButton.addEventListener('click', () => {
            carousel.next();
        });

        carousel.cycle()
    }
}
</script>
