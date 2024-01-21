<template>
    <footer class="bg-malachite-tech-pattern bg-center bg-no-repeat bg-cover" style="box-shadow: 0 -1px 5px #888888">
        <div class="container grid grid-cols-12 gap-x-10 py-60">
            <div class="col-span-2">
                <a href="/">
                    <img src="/img/Logo(full).svg" class="logo w-full" alt="Sendis">
                </a>
            </div>
            <div class="col-start-4 col-end-9">
                <h2 class="text-white text-lg font-semibold mb-20">Компания</h2>
                <ul class="text-white/80 font-semibold">
                    <li class="mb-10">Наименование: <span class="text-white">ООО "СЕНДИС"</span></li>
                    <li class="mb-10">Юр. адрес: <span class="text-white">119180, г. Москва, вн. тер. г. Муниципальный округ Якиманка, ул. Большая Полянка, д. 42, стр.1, этаж 4, помещ. I/комната 25</span></li>
                </ul>
            </div>
            <div class="col-start-10 col-end-13">
                <h2 class="text-white text-lg font-semibold mb-20">Контакты</h2>
                <ul class="text-white/80 font-semibold">
                    <li class="mb-10">Телефон: <a href="tel:+7-495-108-23-28" class="text-white hover:underline">+7 (495) 108-23-28</a></li>
                    <li class="mb-10">E-mail: <a href="mailto:hello@sendis.com" class="text-white hover:underline">info@sendis.ru</a></li>
                </ul>
            </div>
<!--            <div class="col-span-3">-->
<!--                <h2 class="text-white text-lg font-semibold mb-20">Контакты</h2>-->
<!--                <ul class="text-white/80 font-semibold">-->
<!--                    <li class="mb-10">Lorem ipsum: <span class="text-white">123-456-7890</span></li>-->
<!--                    <li class="mb-10">Lorem: <span class="text-white">123-456-7890</span></li>-->
<!--                    <li class="mb-10">E-mail: <a href="mailto:hello@sendis.com" class="text-white hover:underline">hello@sendis.com</a></li>-->
<!--                    <li class="mb-10">Адрес: <span class="text-white">г. Москва, Путевой проезд, 15</span></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="col-span-2">-->
<!--                <h2 class="text-white text-lg font-semibold mb-20">Социальные сети</h2>-->
<!--                <div class="flex gap-x-20">-->
<!--                    <a href="#">-->
<!--                        <iconV class="text-white w-30 hover:scale-110 duration-200" name="telegram" />-->
<!--                    </a>-->
<!--                    <a href="#">-->
<!--                        <iconV class="text-white w-30 hover:scale-110 duration-200" name="viber" />-->
<!--                    </a>-->
<!--                    <a href="#">-->
<!--                        <iconV class="text-white w-30 hover:scale-110 duration-200" name="whatsapp" />-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="container mt-80">
            <hr class="border-t-[3px] border-white">
            <span class="text-white text-sm font-semibold text-center block w-full py-60">© {{new Date().getFullYear()}} <a href="/" class="hover:underline">СЭНДИС</a> | ВСЕ ПРАВА ЗАЩИЩЕНЫ</span>
        </div>
    </footer>
</template>

<script>
import iconV from '@/components/iconV.vue';
export default {
    components: {
        iconV,
    }
}
</script>

