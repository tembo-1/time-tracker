<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Каталог товаров</h1>
        <div class="grid grid-cols-12 gap-x-20">
            <div class="col-span-3 flex flex-col gap-y-20">
                <Filters @search="onSearch" />
                <template v-if="UserData.role === 'Manager'">
                    <buttonV class="btn-white w-full" icon="download" text="Загрузить товары" title="Загрузить excel с товарами" data-te-toggle="modal" data-te-target="#importNewProductsModal"/>

                    <!--Модальное окно импорта-->
                    <Modal id="importNewProductsModal" ref="importNewProductsModal">
                        <p class="text-xl mb-20">Выберите файл в формате xls</p>
                        <form class="flex flex-col gap-y-20 items-center" id="importForm" ref="importForm" enctype="multipart/form-data" @submit.prevent="importNewProducts">
                            <inputV class="inp-light-gray" type="file" accept=".xls,.xlsx" name="excel" required />
                            <buttonV class="btn-white-bordered" text="Загрузить" type="submit" />
                        </form>
                    </Modal>
                </template>
            </div>

            <div class="col-span-9 h-fit grid grid-cols-2 gap-20">
                <div v-if="!FirstLoading" v-for="category in shownCategories" class="white-substrate flex gap-x-20 hover:shadow-lg duration-200">
                    <img :src="category.src || '/mocks/imagePlug.png'"
                         alt="category img" class="w-[226px] h-[226px] aspect-square object-cover">
                    <div class="flex flex-col gap-y-20" :class="{'justify-center' : !category.subcategories.length}">
                        <a :href="`catalog/products?category=${category.id}`"><h2 class="text-xl font-semibold hover:text-main-green duration-200 overflow-wrap-anywhere">{{ category.name }}</h2></a>
                        <a v-for="subcategory in category.subcategories" :href="`catalog/products?category=${subcategory.id}`" class="cus-link text-sm w-fit">{{ subcategory.name }}</a>
                    </div>
                </div>

                <!-- Скелетики 💀💀 -->
                <div v-else v-for="card in 8" class="white-substrate flex gap-x-20">
                    <img src="/mocks/imagePlug.png" alt="category img" class="w-[226px] h-[226px] aspect-square object-cover animate-pulse">
                    <div class="flex w-full flex-col gap-y-20">
                        <span class="w-full h-15 pulsing-frame"></span>
                        <span class="w-2/3 h-15 pulsing-frame"></span>
                        <span v-for="subcategory in 4" class="w-1/2 h-10 pulsing-frame"></span>
                    </div>
                </div>

                <p class="text-center text-xl col-span-full pt-100" v-if="!categories.length && !FirstLoading">Нет результатов</p>

                <div v-if="categories.length >= shownItems && !(categories.length == shownItems && !shown) && !FirstLoading" class="col-span-full flex justify-center pt-40">
                    <buttonV ref="itemsToggler" class="btn-white" :text="shownItems != categories.length ? 'Показать все' : 'Скрыть'" @click="toggleShownItems" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Filters from '@/components/Filters.vue';
import buttonV from '@/components/buttonV.vue';
import {useAppStore} from '@/stores/AppStore.js';
import {mapActions, mapState} from 'pinia';
import inputV from "@/components/inputV.vue";
import Modal from "@/components/Modal.vue";
import {useUserStore} from "@/stores/UserStore.js";
import axios from "axios";
import {useToast} from "vue-toastification";
import Toast from "@/components/Toast.vue";

export default {
    data() {
        return {
            categories: [],
            shownItems: 8,
            shown: false,
            toast: useToast(),
        }
    },
    methods: {
        async getCategories() {
            const response = await axios.get('/categories');
            this.categories = response.data;
        },
        async importNewProducts() {
            try {
                const formData = new FormData(this.$refs.importForm);
                await axios.post('/importOtherDistr', formData);
                this.toast({
                    component: Toast,
                    props: {
                        title: "Импорт успешно завершён",
                        text: `Новые товары добавлены`,
                        icon: "check-mark",
                        type: "success",
                    }
                })
            } catch (error) {
                this.toast({
                    component: Toast,
                    props: {
                        title: "Ошибка при импорте",
                        text: `Попробуйте позже`,
                        icon: "cross",
                        type: "error",
                    }
                })
            } finally {
                this.$refs.importNewProductsModal.close();
                this.$refs.importForm.reset();
            }
        },
        toggleShownItems() {
            if (this.shownItems === this.categories.length) {
                this.shownItems = 8;
                this.shown = false;
                window.scrollTo({ top: 0 });
            } else {
                this.shown = true;
                this.shownItems = this.categories.length;
            }

        },
        onSearch(searchValue) {
            window.location = `catalog/products?search=${searchValue.replace(/ /g, '+')}`;
        },
        ...mapActions(useAppStore, ["firstLoad"]),
    },
    computed: {
        ...mapState(useAppStore, ['FirstLoading']),
        ...mapState(useUserStore, ['UserData']),
        shownCategories() {
            return this.categories.slice(0, this.shownItems);
        },
    },
    mounted() {
        this.firstLoad(this.getCategories);
    },
    components: {
        Modal,
        inputV,
        Filters,
        buttonV,
    },
}
</script>

<!--Есть баг: Если наборать на странице с категориями поисковой запрос, выполнить его, а затем нажать "←" в браузере,
то значение поиска останется в инпуте, оно будет только отображаться, но при этом, значение самого инпута, с точки зрения
браузера, будет пустым. Браузер начинает "чувствовать" значение только после его изменения.
Причина: скорее всего баг идёт со стороны vue, а конкретно от того как он обрабатывает v-model
Статус: решён
Примечание: подобный баг был замечен мною и в других проектах, но предпосылки к нему всё те же Vue + v-model
UPD: Баг решён, надо было поставить autocomplete="off" в инпут, я так понял что это из-за кэширования самого браузера
-->
