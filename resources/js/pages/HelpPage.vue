<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Помощь</h1>
        <div class="grid grid-cols-12 gap-x-20">
            <nav class="white-substrate col-span-3 sticky top-20 h-fit max-h-[90vh] overflow-y-auto">
                <h4 class="text-xl font-semibold">Содержание:</h4>
                <ul class="flex flex-col gap-y-10 mt-10">
                    <li v-for="material in materials"><a class="hover:text-main-green" :href="`#${material.id}`">{{material.title}}</a></li>
                </ul>
            </nav>
            <div class="white-substrate col-span-9 h-fit flex flex-col gap-y-40 divide-solid divide-gray/50 divide-y-3">
                <div v-for="(material, index) in materials" :id="material.id" class="flex flex-col gap-y-20" :class="{'pt-30' : index!==0}">
                    <h2 class="font-semibold text-2xl">{{material.title}}</h2>
                    <video :src="material.videoPath" poster="/img/poster.jpg" controls>
                        <track :src="material.subtitlesPath" kind="subtitles" srclang="ru" label="Русский" default>
                    </video>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HelpPage",
    data() {
        return {
            materials: [
                {
                    id: "Registration",
                    title: "Регистрация",
                    videoPath: "/video/RegTutorial/RegTutorial.mp4",
                    subtitlesPath: "/video/RegTutorial/subtitles/ru.vvt"
                },
                {
                    id: "Cart",
                    title: "Формирование корзины",
                    videoPath: "/video/CartTutorial/CartTutorial.mp4",
                    subtitlesPath: "/video/CartTutorial/subtitles/ru.vvt"
                },
                {
                    id: "Reserve",
                    title: "Создание счёта-резерва",
                    videoPath: "/video/ReserveTutorial/ReserveTutorial.mp4",
                    subtitlesPath: "/video/ReserveTutorial/subtitles/ru.vvt"
                },
                {
                    id: "Project",
                    title: "Создание проектного запроса",
                    videoPath: "/video/ProjectTutorial/ProjectTutorial.mp4",
                    subtitlesPath: "/video/ProjectTutorial/subtitles/ru.vvt"
                },
                {
                    id: "Orders",
                    title: "Мои запросы",
                    videoPath: "/video/OrdersTutorial/OrdersTutorial.mp4",
                    subtitlesPath: "/video/OrdersTutorial/subtitles/ru.vvt"
                },
            ]
        }
    }
}
</script>
