<template>
    <!-- Слайдер -->
    <swiper-container class="w-full relative" style="height: calc(100vh - 120px)" v-bind="sliderOptions">
        <swiper-slide>
            <div class="h-full w-full text-white flex justify-center items-center bg-center bg-cover" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/img/slide1-bg.jpg')">
                <div class="w-1/2 flex flex-col text-8xl leading-none font-semibold">
                    <span class="bg-main-green/80 w-fit p-15">Дистрибуция</span>
                    <span class="w-fit self-center">это</span>
                    <span class="w-fit text-main-light-green self-end">движение</span>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="h-full w-full text-white flex justify-center items-center bg-center bg-cover" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/img/slide2-bg.jpg')">
                <div class="w-1/2 flex flex-col text-8xl leading-none font-semibold">
                    <span class="bg-main-green/80 w-fit p-15">Импортозамещение</span>
                    <span class="w-fit self-center">твоя</span>
                    <span class="w-fit text-main-light-green self-end">реальность</span>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="h-full w-full text-white flex justify-center items-center bg-center bg-cover" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/img/slide3-bg.jpg')">
                <div class="w-1/2 flex flex-col text-8xl leading-none font-semibold">
                    <span class="bg-main-green/80 w-fit p-15">Надежный</span>
                    <span class="w-fit self-center">партнёр</span>
                    <span class="w-fit text-main-light-green self-end">для бизнеса</span>
                </div>
            </div>
        </swiper-slide>
    </swiper-container>
    <div class="container py-100 flex flex-col gap-y-100">
        <div class="flex flex-col gap-y-40 text-center">
            <h1 class="font-semibold">Дистрибутор SENDIS Ваш надежный партнёр!</h1>
            <div class="flex items-center">
                <span class="border-b-3 border-main-green flex-grow"></span>
                <h3 class="text-main-green px-30">РЕШЕНИЯ ДЛЯ БИЗНЕСА ЛЮБОГО УРОВНЯ</h3>
                <span class="border-b-3 border-main-green flex-grow"></span>
            </div>
            <p class="text-2xl">Наша стратегия - расширение ассортимента предлагаемой продукции и переориентация рынков сбыта, освоение новых видов производств с целью повышения эффективности и уменьшения рисков</p>

            <div class="grid grid-cols-3 gap-x-60 mt-20 text-start text-lg">
                <div class="white-substrate duration-200 hover:text-white hover:bg-main-green">
                    <div class="flex gap-x-20">
                        <iconV class="w-50" name="briefcase" />
                        <h4 class="font-semibold text-xl">Поддержка российских ИТ-вендоров</h4>
                    </div>
                    <p class="mt-10 е">Санкционная устойчивость ИТ-решений. Доступность технических специалистов, когда необходимо оперативное взаимодействие</p>
                </div>
                <div class="white-substrate duration-200 hover:text-white hover:bg-main-green">
                    <div class="flex gap-x-20">
                        <iconV class="w-60" name="growth" />
                        <h4 class="font-semibold text-xl">Широкопрофильная дистрибуция</h4>
                    </div>
                    <p class="mt-10">Нацеленность на постоянное развитие с помощью цифровых технологий и предоставление партнерам широких возможности развития их бизнеса</p>
                </div>
                <div class="white-substrate duration-200 hover:text-white hover:bg-main-green">
                    <div class="flex gap-x-20">
                        <iconV class="w-60" name="handshake" />
                        <h4 class="font-semibold text-xl">Прозрачные отношения для всех!</h4>
                    </div>
                    <p class="mt-10">Принятые обязательства должны выполняться. Долгосрочные партнерские отношения важнее сиюминутной выгоды</p>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 auto-rows-min gap-y-20 gap-x-100">
            <h3 class="font-semibold text-2xl col-start-1 col-end-3">Построй свой <span class="text-main-green">бизнес</span> вместе с нами</h3>
            <div class="flex flex-col gap-y-20 text-xl">
                <p>Мы за прозрачные отношения и взаимовыгодный бизнес. Репутация – наше конкурентное преимущество. Мы
                    ценим наших партнеров, выстраиваем отношения на принципах доверия и взаимного уважения. Создаем
                    удобные сервисы для долгосрочных партнерских отношений с нашей компанией.
                </p>
                <div class="flex justify-between">
                    <ul class="leading-loose">
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Широкий ассортимент
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Ставка на новых производителей
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Генерация дохода в канале
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Развитая система логистики
                        </li>
                    </ul>
                    <ul class="leading-loose">
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Индивидуальный подход
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Развитие бизнеса
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Изучение потребностей
                        </li>
                        <li class="flex items-center gap-x-10 hover:text-main-green duration-200 w-fit">
                            <span class="font-semibold text-xl">✔</span>Рекомендации и обучение
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-x-40 text-2xl font-semibold">
                <div
                    class="white-substrate flex flex-col gap-y-20 items-center justify-center hover:text-main-green duration-200">
                    <iconV class="w-60" name="empty-star"/>
                    <p>26</p>
                    <p>ИТ-вендоров</p>
                </div>
                <div
                    class="white-substrate flex flex-col gap-y-20 items-center justify-center hover:text-main-green duration-200">
                    <span class="text-6xl">#</span>
                    <p>1023</p>
                    <p>Товарные позиции</p>
                </div>
            </div>
            <a href="/registration" class="btn btn-green hover:bg-main-green-700 w-fit text-lg">Присоединиться</a>
        </div>

        <div class="pb-60">
            <h2 class="text-4xl text-center font-semibold">Наши партнёры</h2>
            <div class="grid grid-cols-3 gap-x-80 mt-80">
                <div class="flex items-center justify-center grayscale hover:grayscale-0 duration-200">
                    <img src="/img/pantum-partner.png" alt="partner">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 duration-200">
                    <img src="/img/aurora-partner.png" class="self-center" alt="partner">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 duration-200">
                    <img src="/img/basis-partner.png" class="self-center" alt="partner">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import iconV from "@/components/iconV.vue";
import buttonV from "@/components/buttonV.vue";
import {register} from "swiper/element/bundle";
register()

export default {
    data() {
        return {
            page: 'main',
            sliderOptions: {
                loop: true,
                autoplay: {
                    delay: 4000
                },
                effect: 'creative',
                creativeEffect: {
                    prev: {
                        shadow: true,
                        translate: ['-20%', 0, -1],
                    },
                    next: {
                        translate: ['100%', 0, 0],
                    },
                },
            },
        }
    },
    components: {
        buttonV,
        iconV,
    },
}
</script>
