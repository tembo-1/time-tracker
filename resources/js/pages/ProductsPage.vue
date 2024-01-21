<template>
    <div class="container pb-100">
        <h1 v-if="!FirstLoading" class="text-center my-60">{{pageTitle}}</h1>
        <span v-else class="w-2/5 my-60 mx-auto h-50 pulsing-frame"></span>
        <div class="grid grid-cols-12 gap-x-20">
            <Filters class="col-span-3" @search="onSearch" @search-clean="onSearchClean" />
            <div class="col-span-9 relative">
                <TableV class="white-substrate text-sm" :columns="[
                    {title: '+', class: 'text-center opacity-0', hidden: UserData.role === 'Manager'},
                    {title: 'Артикул', sortField: 'article'},
                    {title: 'Наименование', sortField: 'name'},
                    {title: 'Вендор', sortField: 'vendor'},
                    {title: 'Поставщик', hidden: UserData.role !== 'Manager'},
                    {title: 'Добавлено', hidden: UserData.role !== 'Manager'},
                    {title: 'Склад', sortField: 'quantity'},
                    {title: 'Транзит', sortField: 'transit'},
                    {title: 'Цена $', hidden: UserData.role === 'Guest', sortField: 'price', class: 'whitespace-nowrap'},
                    {title: 'Цена ₽', hidden: UserData.role === 'Guest', class: 'whitespace-nowrap'},
                    ]" :data="products" :loading="FirstLoading">
                    <template #+="{item}">
                        <td class="p-10">
                            <div class="relative w-fit mx-auto group cursor-pointer" @click="addToCart(item)">
                                <badge v-if="item.count" class="absolute top-5 right-5" :value="item.count" />
                                <buttonV icon="basket" class="p-10 mx-auto group-hover:text-main-green duration-200"/>
                            </div>
                        </td>
                    </template>

                    <template #Артикул="{item}">
                        <td class="p-10 break-words max-w-[150px]">
                            {{ item.article }}
                        </td>
                    </template>

                    <template #Наименование="{item}">
                        <td class="p-10 break-words max-w-[400px]">
                            {{ item.name }}
                        </td>
                    </template>

                    <template #Вендор="{item}">
                        <td class="p-10">
                            {{ item.vendor }}
                        </td>
                    </template>

                    <template #Поставщик="{item}">
                        <td class="p-10">
                            {{ item.distributor }}
                        </td>
                    </template>

                    <template #Добавлено="{item}">
                        <td class="p-10">
                            {{ item.created_at }}
                        </td>
                    </template>

                    <template #Склад="{item}">
                        <td class="p-10">
                            {{ item.quantity }}
                        </td>
                    </template>

                    <template #Транзит="{item}">
                        <td class="p-10">
                            {{ item.transit }}
                        </td>
                    </template>

                    <template #Цена_$="{item}">
                        <td class="p-10 whitespace-nowrap">
                            {{ item.price }}
                        </td>
                    </template>

                    <template #Цена_₽="{item}">
                        <td class="p-10 whitespace-nowrap">
                        </td>
                    </template>
                </TableV>
                <hint class="absolute right-10 top-10" hint-classes="w-[300px]">Используйте <b>Shift + Колёсико мыши</b> для прокрутки таблицы по горизонтали</hint>

                <Pagination v-if="products.length && !FirstLoading" :pages="amountOfPages" :current="Number(Params.page) || 1" ref="pagination" class="mt-60" @change-page="moveToPage" />
            </div>
        </div>
    </div>
</template>

<script>
import Filters from '@/components/Filters.vue';
import buttonV from '@/components/buttonV.vue';
import Pagination from '@/components/Pagination.vue';
import hint from "@/components/hint.vue";
import Toast from "@/components/Toast.vue";
import iconV from "@/components/iconV.vue";
import TableV from "@/components/TableV.vue";
import {useAppStore} from '@/stores/AppStore';
import {useUserStore} from '@/stores/UserStore.js';
import {mapActions, mapState, mapWritableState} from 'pinia';
import {useToast} from "vue-toastification";
import badge from "@/components/badge.vue";
import {debounce} from "@/helpers/Debounce.js";
export default {
    data() {
        return {
            products: [],
            amountOfPages: null,
            addedProduct: '',
            pageTitle: 'Каталог товаров',
            syncCount: debounce(this.syncProductsCount, 500),
            productsToSync: {},
            toast: useToast(),
        }
    },
    methods: {
        async getProducts() {
            const response = await axios.get('/products' + this.getParams().paramsString);
            this.products = response.data.data;
            //                                 ↓meta (лишний слой в ресурсе)
            this.amountOfPages = response.data.meta.last_page;
        },
        async addToCart(product) {
            if (this.Auth) {
                const count = product.count + 1 || 1;
                const productIndex = this.products.findIndex(p => p.id === product.id);
                if (productIndex !== -1) {
                    this.products[productIndex].count = count;
                }

                this.productsToSync[product.id] = {id: product.id, count: product.count};
                this.syncCount();

                this.addedProduct = product.name;
                this.toast({
                    component: Toast,
                    props: {
                        title: "Товар добавлен в корзину",
                        text: `Вы добавили ${this.addedProduct} в свою корзину`,
                        icon: "cart",
                    }
                });

            } else {
                window.location = '/login';
            }
        },
        async syncProductsCount() {
            for (let product of Object.values(this.productsToSync)) {
                delete this.productsToSync[product.id];
                await axios.post('/cart', {product_id: product.id, count: product.count});
            }
            this.getCartCount();
        },
        async getCategoryInfo() {
            if (this.Params.category) {
                const response = await axios.get(`/categories/${this.Params.category}/info`);
                if (response.data) {
                    this.pageTitle = document.title = response.data;
                }
            }
        },
        moveToPage(page) {
            if (page > 1) {
                this.Params.page = page;
            }  else  {
                this.Params.page = null;
            }
            this.pushToHistory();
            this.getProducts();
            window.scrollTo({ top: 0 });
        },
        onSearch(searchValue) {
            this.Params.page = null;
            this.Params.search = searchValue;
            this.pushToHistory();
            this.getProducts();
        },
        onSearchClean(){
            this.Params.page = null;
            this.Params.search = null;
            this.pushToHistory();
            this.getProducts();
        },
        // Метод вызываемый при навигации по истории (кнопоки "вперёд" "назад" в браузере)
        onPopState() {
            window.scrollTo({ top: 0 });
            this.getProducts();
        },
        ...mapActions(useAppStore, ["firstLoad", "pushToHistory", "getParams"]),
        ...mapActions(useUserStore, ["getCartCount"]),
    },
    computed: {
        ...mapState(useAppStore, ['FirstLoading']),
        ...mapWritableState(useAppStore, ['Params']),
        ...mapState(useUserStore, ['Auth', 'UserData']),
    },
    mounted() {
        this.firstLoad(this.getProducts, this.getCategoryInfo);
        window.addEventListener('popstate', this.onPopState);
    },
    components: {
        badge,
        TableV,
        iconV,
        Filters,
        buttonV,
        Pagination,
        hint,
    },
}
</script>

