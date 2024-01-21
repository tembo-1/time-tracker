<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Корзина</h1>
        <div class="grid grid-cols-12 gap-20">
            <div class="white-substrate flex justify-between col-span-full">
                <div class="flex gap-x-20">
                    <inputV class="inp-light-gray w-[450px]" v-model="articles" placeholder="Введите артикулы через пробел"/>
                    <buttonV class="btn-white-bordered" text="Добавить" :disabled="!articles.length" @click="addByArticlesArray" />
                    <buttonV class="btn-white-bordered" text="Импорт" data-te-toggle="modal" data-te-target="#importArticlesModal" />

                    <!--Модальное окно импорта-->
                    <Modal id="importArticlesModal" ref="importArticlesModal">
                        <p class="text-xl mb-20">Выберите файл в формате xls</p>
                        <form class="flex flex-col gap-y-20 items-center" id="importForm" enctype="multipart/form-data" @submit.prevent="addByImportFile">
                            <inputV class="inp-light-gray" v-model="file" type="file" accept=".xls,.xlsx" name="excel" required />
                            <buttonV class="btn-white-bordered" text="Импорт" type="submit" />
                        </form>
                    </Modal>
                </div>
                <div class="flex items-center gap-x-60" v-if="cartItems.length && !FirstLoading">
                    <checkboxV label="Выбрать все" id="selectAllCheckbox" v-model="selectAll" @change="selectAllItems" />
                    <buttonV class="btn-white shadow-none bg-transparent text-gray p-0" text="Удалить выбранные" :disabled="!isSomeSelected" @click="openDeleteModal(getSelectedItems())" />
                </div>
            </div>
            <form id="productsForm" class="flex flex-col gap-y-20 col-span-9">
                <div v-if="!FirstLoading" v-for="item in cartItems" :key="item.product.id" class="white-substrate relative grid grid-cols-12 gap-x-20" :class="{'bg-gray/10' : !item.product.status}">
                    <checkboxV :id="`productSelectCheckbox${item.product.id}`" v-model="item.selected" name="products[]" :value="item.product.id" shell-classes="absolute top-10 left-10" @change="updateSelectAll" />
                    <img src="/mocks/imagePlug.png" alt="product img" class="col-span-2 aspect-square object-cover">
                    <div class="flex flex-col gap-y-20 col-span-5">
                        <h4 class="break-words">{{item.product.name}}</h4>
                        <p class="text-gray text-base">Артикул: {{item.product.article}}</p>
                        <p v-if="item.product.status" class="text-base"><b>Склад:</b> {{item.product.quantity}}</p>
                        <p v-if="item.product.status" class="text-base"><b>Транзит:</b> {{item.product.transit}}</p>
                        <p v-else class="text-base font-semibold">Товара нет в наличии</p>
                    </div>
                    <div class="flex flex-col gap-y-20 col-span-3">
                        <Counter :initial-value="item.count" @count-updated="editCartItemCount($event, item.product.id)" @count-invalid="openDeleteModal([item.product.id])" />
                        <p v-if="item.product.status" class="text-base"><b>Цена:</b> {{item.product.currency_price}} ₽</p>
                        <p v-if="item.product.status" class="text-base"><b>Стоимость:</b> {{ item.result }} ₽</p>
                    </div>
                    <div class="flex h-fit gap-x-20 justify-end col-span-2">
                        <buttonV icon="empty-star" class="p-0 w-30 h-30 btn-gray-hovered-dark" />
                        <buttonV icon="trash" class="p-0 w-30 h-30 btn-gray-hovered-dark" @click="openDeleteModal([item.product.id])" />
                    </div>
                </div>

                <!-- Скелетики 💀💀 -->
                <div v-if="FirstLoading" v-for="item in 3" class="white-substrate relative grid grid-cols-12 gap-x-20">
                    <img src="/mocks/imagePlug.png" alt="product img" class="col-span-2 aspect-square object-cover animate-pulse">
                    <div class="flex flex-col gap-y-20 col-span-5">
                        <span class="w-full h-20 pulsing-frame"></span>
                        <span class="w-3/4 h-15 pulsing-frame"></span>
                        <span class="w-3/5 h-15 pulsing-frame"></span>
                        <span class="w-3/4 h-15 pulsing-frame"></span>
                    </div>
                    <div class="flex flex-col gap-y-20 col-span-3">
                        <span class="w-2/5 h-40 rounded-5 pulsing-frame"></span>
                        <span class="w-3/5 h-15 pulsing-frame"></span>
                        <span class="w-3/5 h-15 pulsing-frame"></span>
                    </div>
                    <div class="flex h-fit gap-x-20 justify-end col-span-2">
                        <span class="w-30 h-30 rounded-5 pulsing-frame"></span>
                        <span class="w-30 h-30 rounded-5 pulsing-frame"></span>
                    </div>
                </div>

                <div v-if="!cartItems.length && !FirstLoading" class="white-substrate flex flex-col gap-y-20 justify-center items-center">
                    <p class="text-xl">Ваша корзина пуста</p>
                    <p>Выберите товары в нашем <a href="/catalog" class="cus-link">каталоге</a></p>
                </div>
            </form>
            <div class="white-substrate flex flex-col gap-y-40 col-span-3 h-fit">
                <div v-if="cartItems.length && !FirstLoading" class="flex flex-col gap-y-20 font-semibold text-xl">
                    <p>Итого:</p>
                    <div class="flex justify-between">
                        <p>{{ amountOfProducts }}</p>
                        <p class="text-end">{{ inTotal }} ₽</p>
                    </div>
                </div>
                <div v-if="cartItems.length && !FirstLoading" class="flex flex-col gap-y-20">
                    <buttonV data-te-toggle="modal" data-te-target="#simpleOrderModal" class="btn-green" text="Создать счёт-резерв" />
                    <buttonV data-te-toggle="modal" data-te-target="#projectOrderModal" class="btn-green" text="Создать проектный запрос" />
                    <buttonV class="btn-green px-10" text="Добавить в существующий запрос" />
                    <a href="/order/export" class="block">
                        <buttonV class="btn-green w-full" text="Выгрузить excel" />
                    </a>

                    <!--Модальное окно простого запроса-->
                    <Modal id="simpleOrderModal" ref="simpleOrderModal">
                        <form class="w-[450px] flex flex-col gap-y-20" ref="simpleOrderForm" @submit.prevent="makeOrder('simple')">
                            <p class="text-xl text-center">Создание счета-резерва</p>
                            <inputV class="inp-light-gray w-full" label="Организация" :value="UserData.info.organisation" name="organisation" id="organisationSimple" readonly  />
                            <inputV class="inp-light-gray w-full" label="Менеджер" :value="`${UserData.manager.firstname} ${UserData.manager.lastname}`" name="manager" id="managerSimple" readonly  />
                            <inputV class="inp-light-gray w-full" type="date" label="Срок реализации" name="implementationTime" :min="currentDate" />
                            <div class="flex justify-center">
                                <buttonV class="btn-green w-fit" type="submit" text="Создать" />
                            </div>
                        </form>
                    </Modal>

                    <!--Модальное окно проектного запроса-->
                    <Modal id="projectOrderModal" ref="projectOrderModal">
                        <form class="w-[450px] flex flex-col gap-y-20" ref="projectOrderForm" @submit.prevent="makeOrder('project')">
                            <p class="text-xl text-center">Создание проектного запроса</p>
                            <inputV class="inp-light-gray w-full" label="Организация" :value="UserData.info.organisation" name="organisation" id="organisationProject" readonly />
                            <inputV class="inp-light-gray w-full" label="Менеджер" :value="`${UserData.manager.firstname} ${UserData.manager.lastname}`" name="manager" id="managerProject" readonly />
                            <inputV class="inp-light-gray w-full" label="Заказчик" placeholder="Укажите конечного заказчика" name="customer" />
                            <inputV class="inp-light-gray w-full appearance-none" type="number" label="ИНН" placeholder="Введите ИНН" name="inn" />
                            <selectV class="inp-light-gray" label="Регион" name="region" >
                                <option value="" selected disabled>Выберите регион</option>
                                <option :value="region.id" v-for="region in Regions">{{region.name}}</option>
                            </selectV>
                            <selectV class="inp-light-gray" v-model="requestType" label="Тип запроса" name="requestType" id="requestType" >
                                <option value="" selected disabled>Выберите тип запроса</option>
                                <option value="Сбор КП">Сбор КП</option>
                                <option value="Участие в конкурсе">Участие в конкурсе</option>
                            </selectV>
                            <inputV v-if="requestType === 'Участие в конкурсе'" class="inp-light-gray w-full" label="Ссылка на конкурс" placeholder="Вставьте ссылку на конкурс" name="contestLink" />
                            <textareaV class="inp-light-gray w-full" label="Условия поставки" placeholder="Срок поставки, разовая или по запросам, возможна ли частичная поставка" name="deliveryConditions"  />
                            <textareaV class="inp-light-gray w-full" label="Существенные условия сделки" placeholder="Введите существенные условия сделки" name="essentialConditions"  />
                            <inputV class="inp-light-gray w-full" type="datetime-local" label="Сколько есть времени на обработку запроса" name="processingTime" :min="currentDateTime" />
                            <checkboxV label="Создать счет/резерв" name="createReserve" value="1" />
                            <div class="flex justify-center">
                                <buttonV class="btn-green w-fit" type="submit" text="Создать запрос" />
                            </div>
                        </form>
                    </Modal>
                </div>

                <!-- Скелетики 💀💀 -->
                <div v-if="FirstLoading" class="flex flex-col gap-y-20">
                    <span class="w-1/3 h-20 pulsing-frame"></span>
                    <div class="flex justify-between mb-20">
                        <span class="w-1/3 h-15 pulsing-frame"></span>
                        <span class="w-1/2 h-15 pulsing-frame"></span>
                    </div>

                    <span class="w-full h-40 rounded-5 pulsing-frame"></span>
                    <span class="w-full h-40 rounded-5 pulsing-frame"></span>
                    <span class="w-full h-40 rounded-5 pulsing-frame"></span>
                </div>

                <a href="/catalog" class="block" v-if="!cartItems.length && !FirstLoading">
                    <buttonV class="btn-green w-full" text="Перейти в каталог" />
                </a>
            </div>
        </div>
    </div>
    <!--Модальное окно удаления товара-->
    <Modal id="deleteModal" ref="deleteModal" @modal-hide="itemsToDelete = null">
        <div class="flex flex-col gap-y-20 items-center">
            <iconV name="exclamation" class="fill-error w-40 h-40" />
            <p class="text-xl text-center">Удалить выбранный товар из корзины?</p>
            <div class="flex gap-x-20">
                <buttonV class="btn-danger w-full" text="Удалить" @click="deleteCartItems(itemsToDelete)" />
                <buttonV data-te-modal-dismiss aria-label="Close" class="btn-white-bordered w-full" text="Отмена" />
            </div>
        </div>
    </Modal>

    <!--Модальное окно уведомления-->
    <Modal id="alertModal" ref="alertModal" @modal-hidden="notFoundArticles = null; importBy = null">
        <div class="flex flex-col gap-y-20 items-center max-w-[460px]">
            <div class="flex gap-x-20 items-center pr-20">
                <iconV name="exclamation" class="w-40 h-40" />
                <p class="text-xl">{{alertText}}</p>
            </div>
            <ul class="w-full list-disc list-inside text-lg">
               <li v-for="article in notFoundArticles">{{article}}</li>
            </ul>
            <buttonV v-if="importBy" data-te-modal-dismiss aria-label="Close" class="btn-white-bordered w-fit" text="Ок" />
            <div v-else class="flex justify-center gap-x-20">
                <buttonV data-te-modal-dismiss aria-label="Close" class="btn-white-bordered w-fit" text="Отмена" />
                <buttonV data-te-modal-dismiss aria-label="Close" class="btn-green w-fit" text="Продолжить" @click="confirmOrder" />
            </div>
        </div>
    </Modal>
</template>

<script>
import inputV from "@/components/inputV.vue";
import buttonV from "@/components/buttonV.vue";
import iconV from "@/components/iconV.vue";
import checkboxV from "@/components/checkboxV.vue";
import Counter from "@/components/Counter.vue";
import Modal from "@/components/Modal.vue";
import selectV from "@/components/selectV.vue";
import textareaV from "@/components/textareaV.vue";
import Toast from "@/components/Toast.vue";
import { useAppStore } from '@/stores/AppStore.js';
import { useUserStore } from '@/stores/UserStore.js';
import {mapActions, mapState, mapWritableState} from 'pinia';
import { getDeclinatedWord } from "@/helpers/DeclinatedWord.js";
import { useToast } from "vue-toastification";


export default {
    name: "CartPage",
    data() {
        return {
            requestType: '',
            cartItems: [],
            selectAll: false,
            itemsToDelete: null,
            amountOfProducts: '',
            inTotal: 0,
            articles: '',
            alertText: '',
            notFoundArticles: null,
            importBy: null,
            file: null,
            toast: useToast(),
            currentDate: new Date().toISOString().split("T")[0],
            currentDateTime: new Date().toISOString().split("T")[0] + 'T' + new Date().toLocaleTimeString().slice(0,5),
        }
    },
    methods: {
        async getCartItems() {
            const response = await axios.get('/cartItems');
            this.cartItems = response.data;
        },
        async deleteCartItems(items){
            if (items.length) {
                this.cartItems = this.cartItems.filter(item => !items.includes(item.product.id));
                await axios.delete('/cartItems', {data: {product_id: items}});
                this.$refs.deleteModal.close();
                this.getCartItems();
                this.getCartInfo();
            }
        },
        async getCartInfo() {
            const response = await axios.get('/cartItems/info');
            this.amountOfProducts = getDeclinatedWord(response.data.count, 'товар');
            this.inTotal = response.data.price;
            this.getCartCount();
        },
        async editCartItemCount(count, product_id) {
            await axios.post('/cart', {product_id: product_id, count: count});
            this.getCartInfo();
            this.getCartItems();
        },
        async importCartItems() {
            try {
                let response;
                if (this.importBy === 'array') {
                    const articlesArray = this.articles.trim().split(/\s+/);
                    response = await axios.post('/importCartItems', {article: articlesArray});
                    this.articles = '';
                } else if (this.importBy === 'file') {
                    this.$refs.importArticlesModal.close();
                    const formData = new FormData(document.getElementById('importForm'));
                    if (formData.get('excel').name && formData.get('excel').size) {
                        response = await axios.post('/importCartItems', formData);
                    }
                    this.file = '';
                }
                this.notFoundArticles = response.data.notFound;
                this.getCartItems();
                this.getCartInfo();
                if (this.notFoundArticles.length) {
                    this.alertText = 'Следующие артикулы не были найдены:'
                    this.$refs.alertModal.open();
                } else {
                    this.toast({
                        component: Toast,
                        props: {
                            title: "Импорт успешно завершён",
                            text: `Все указанные артикулы были добавлены в корзину`,
                            icon: "check-mark",
                            type: "success",
                        }
                    })
                }
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
            }
        },
        async makeOrder(type) {
            try {
                let formData;
                if (type === "project") {
                    formData = new FormData(this.$refs.projectOrderForm);
                } else if (type === 'simple') {
                    formData = new FormData(this.$refs.simpleOrderForm);
                }
                formData.set('type', type)

                await axios.post('/order', formData);

                this.finishOrderMaking();

            } catch (error) {
                if (error.response.status === 422) {
                    this.setValidationErrors(error.response.data.errors, 5000);
                } else if (error.response.status === 410) {
                    this.$refs.simpleOrderModal.close();
                    this.notFoundArticles = error.response.data.message;
                    this.alertText = 'В счёт-резерв не войдут отсутствующие артикулы:'
                    this.$refs.alertModal.open();
                } else {
                    this.toast({
                        component: Toast,
                        props: {
                            title: "Произошла ошибка",
                            text: `Попробуйте позже`,
                            icon: "cross",
                            type: "error",
                        }
                    })
                }
            }
        },
        async confirmOrder() {
            try {
                const formData = new FormData(this.$refs.simpleOrderForm);
                formData.set('type', 'simple')
                await axios.post('/order/confirm', formData);
                this.finishOrderMaking();

            } catch (error) {
                this.toast({
                    component: Toast,
                    props: {
                        title: "Произошла ошибка",
                        text: `Попробуйте позже`,
                        icon: "cross",
                        type: "error",
                    }
                })
            }

        },
        finishOrderMaking() {
            this.FirstLoading = true;
            this.firstLoad(this.getCartItems, this.getCartInfo);

            this.$refs.simpleOrderModal.close();
            this.$refs.projectOrderModal.close();
            this.toast({
                component: Toast,
                props: {
                    title: "Заказ принят в обработку",
                    text: 'Отслеживать статус заказа можно на странице "Мои запросы"',
                    icon: "check-mark",
                    type: "success",
                }
            }, {
                timeout: false,
            })
        },
        updateSelectAll() {
            this.selectAll = this.cartItems.every(item => item.selected);
        },
        selectAllItems() {
          if (this.selectAll) {
              this.cartItems.forEach(item => item.selected = true);
          }  else {
              this.cartItems.forEach(item => item.selected = false);
          }
        },
        getSelectedItems() {
            return this.cartItems.filter(item => item.selected).map(item => item.product.id);
        },
        openDeleteModal(items) {
            if (items.length) {
                this.itemsToDelete = items;
                this.$refs.deleteModal.open();
            }
        },
        addByImportFile() {
            this.importBy = 'file';
            this.importCartItems();
        },
        addByArticlesArray() {
            this.importBy = 'array';
            this.importCartItems();
        },
        ...mapActions(useAppStore, ["firstLoad", "setValidationErrors", "getRegions"]),
        ...mapActions(useUserStore, ["getCartCount"]),
    },
    computed: {
        ...mapWritableState(useAppStore, ['FirstLoading']),
        ...mapState(useAppStore, ["Regions"]),
        ...mapState(useUserStore, ["UserData"]),
        isSomeSelected() {
            return this.cartItems.some(item => item.selected)
        }
    },
    watch: {
        cartItems(newItems, oldItems) {
            if (newItems.length) {
                // Поскольку после обновления cartItems теряют selected, восстанавливаем их для каждого итема
                newItems.forEach(item => item.selected = oldItems.find(oldItem => oldItem.product.id == item.product.id)?.selected || false);
            } else {
                this.selectAll = false;
            }
      }
    },
    mounted() {
        this.firstLoad(this.getCartItems, this.getCartInfo, this.getRegions);
    },
    components: {
        textareaV,
        selectV,
        Modal,
        inputV,
        buttonV,
        iconV,
        checkboxV,
        Counter,
    }
}
</script>

