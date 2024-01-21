<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Запросы</h1>
        <div class="white-substrate flex justify-between items-end">
            <div class="flex gap-x-20 items-end">
                <selectV class="inp-light-gray w-[250px]" value="entranceDate" label="Сортировать по:">
                    <option selected value="entranceDate">Дате поступления</option>
                    <option value="changeDate">Дате последнего изменения</option>
                    <option value="type">Типу</option>
                    <option value="status">Статусу</option>
                    <option value="number">Номеру</option>
                </selectV>

                <selectV class="inp-light-gray w-[250px]" label="Статус:">
                    <option selected value="">Все</option>
                </selectV>

                <selectV class="inp-light-gray w-[250px]" label="Тип:">
                    <option selected value="">Все</option>
                </selectV>

                <inputV class="inp-light-gray w-[250px]" placeholder="Номер"/>
            </div>
            <buttonV class="btn-green h-fit" text="Выгрузить" title="Выгрузить Excel" :disabled="!isSomeSelected" @click="exportSelectedOrders" />
            <buttonV class="btn-green h-fit" text="Загрузить" title="Загрузить Excel" data-te-toggle="modal" data-te-target="#importOrdersDataModal"/>

            <!--Модальное окно импорта-->
            <Modal id="importOrdersDataModal" ref="importOrdersDataModal">
                <p class="text-xl mb-20">Выберите файл в формате xls</p>
                <form class="flex flex-col gap-y-20 items-center" id="importForm" ref="importForm" enctype="multipart/form-data" @submit.prevent="updateOrdersData">
                    <inputV class="inp-light-gray" type="file" accept=".xls,.xlsx" name="excel" required />
                    <buttonV class="btn-white-bordered" text="Загрузить" type="submit" />
                </form>
            </Modal>
        </div>


        <TableV :loading="FirstLoading" with-collapse class="white-substrate mt-20 text-sm" :columns="[
            {title: '+', class: 'opacity-0'},
            {title:'Номер'},
            {title:'Статус'},
            {title:'Тип'},
            {title:'Цель'},
            {title:'Огранизация'},
            {title:'Заказчик'},
            {title:'ИНН'},
            {title:'Регион'},
            {title:'Ссылка на конкурс'},
            {title:'Дедлайн'},
            {title:'Срок поставки'},
            {title:'Существенные условия'},
            {title:'Требуется резерв'},
            {title:'Время создания'},
            ]" :data="orders" emptiness-message="Нет запросов">
            <template #+="{item: order}">
                <td class="p-10">
                    <checkboxV :value="order.id" v-model="order.selected"/>
                </td>
            </template>
            <template #Номер="{item: order}">
                <td class="p-10">
                    #{{ order.id }}
                </td>
            </template>
            <template #Статус="{item: order}">
                <td class="p-10">
                    <selectV class="inp-light-gray text-sm" v-model="order.status" @change="changeStatus(order.id, $event.target.value)">
                        <option value="На рассмотрении">На рассмотрении</option>
                        <option value="Цены согласованы">Цены согласованы</option>
                    </selectV>
                </td>
            </template>
            <template #Тип="{item: order}">
                <td class="p-10">
                    {{ order.type }}
                </td>
            </template>
            <template #Цель="{item: order}">
                <td class="p-10">
                    {{ order.info.requestType }}
                </td>
            </template>
            <template #Огранизация="{item: order}">
                <td class="p-10">
                    {{ order.info.organisation }}
                </td>
            </template>
            <template #Заказчик="{item: order}">
                <td class="p-10">
                    {{order.info.customer}}
                </td>
            </template>
            <template #ИНН="{item: order}">
                <td class="p-10">
                    {{order.info.inn}}
                </td>
            </template>
            <template #Регион="{item: order}">
                <td class="p-10">
                    {{order.region}}
                </td>
            </template>
            <template #Ссылка_на_конкурс="{item: order}">
                <td class="p-10">
                    {{ order.info.contestLink }}
                </td>
            </template>
            <template #Дедлайн="{item: order}">
                <td class="p-10">
                    {{ order.processingTime || order.implementationTime }}
                </td>
            </template>
            <template #Срок_поставки="{item: order}">
                <td class="p-10 max-w-[250px]">
                    {{ order.info.deliveryConditions }}
                </td>
            </template>
            <template #Существенные_условия="{item: order}">
                <td class="p-10 max-w-[250px]">
                    {{ order.info.essentialConditions }}
                </td>
            </template>
            <template #Требуется_резерв="{item: order}">
                <td class="p-10">
                    {{ order.info.createReserve ? 'Да' : 'Нет' }}
                </td>
            </template>
            <template #Время_создания="{item: order}">
                <td class="p-10">
                    {{ order.created_at }} {{ order.time }}
                </td>
            </template>
            <template #collapseContent="{item: order}">
                <TableV class="px-20 text-xs" tr-additional-classes="!border-gray" :columns="[
                    {title:'#'},
                    {title:'Наименование'},
                    {title:'Артикул'},
                    {title:'Поставщик'},
                    {title:'Вендор'},
                    {title:'Требуемое кол-во'},
                    {title:'Кол-во в резерве'},
                    {title:'Кол-во в транзите'},
                    {title:'Дата транзита'},
                    {title:'Цена $'},
                    {title:'Цена ₽'},
                    {title:'Цена со скидкой'},
                    {title:'Срок действия цены'},
                    {title:'Срок действия резерва'},
                    {title:'Срок поставки'},
                    {title:'Отгружен'},
                    {title:'Номер счёта'},
                    ]" :data="order.items">
                    <template ##={index}>
                        <td class="p-10">
                            {{ index + 1 }}
                        </td>
                    </template>
                    <template #Наименование="{item}">
                        <td class="p-10 max-w-[300px] break-words">
                            {{ item.name }}
                        </td>
                    </template>
                    <template #Артикул="{item}">
                        <td class="p-10">
                            {{ item.article }}
                        </td>
                    </template>
                    <template #Поставщик="{item}">
                        <td class="p-10">
                            {{ item.distr }}
                        </td>
                    </template>
                    <template #Вендор="{item}">
                        <td class="p-10">
                            {{ item.vendor }}
                        </td>
                    </template>
                    <template #Требуемое_кол-во="{item}">
                        <td class="p-10">
                            {{ item.count }}
                        </td>
                    </template>
                    <template #Кол-во_в_резерве="{item}">
                        <td class="p-10">
                            {{ item.quantity }} {{item.quantity_manager ? `(${item.quantity_manager})` : ''}}
                        </td>
                    </template>
                    <template #Кол-во_в_транзите="{item}">
                        <td class="p-10">
                            {{ item.transit }} {{item.transit_manager ? `(${item.transit_manager})` : ''}}
                        </td>
                    </template>
                    <template #Дата_транзита="{item}">
                        <td class="p-10">
                            {{ item.transitdate }} {{item.transitdate_manager ? `(${item.transitdate_manager})` : ''}}
                        </td>
                    </template>
                    <template #Цена_$="{item}">
                        <td class="p-10 whitespace-nowrap">
                            {{ item.price }}
                        </td>
                    </template>
                    <template #Цена_₽="{item}">
                        <td class="p-10">
                        </td>
                    </template>
                    <template #Цена_со_скидкой="{item}">
                        <td class="p-10 whitespace-nowrap">
                            {{ item.new_price || '...' }}
                        </td>
                    </template>
                    <template #Срок_действия_цены="{item}">
                        <td class="p-10">
                            {{ item.price_validity_period || '...' }}
                        </td>
                    </template>
                    <template #Срок_действия_резерва="{item}">
                        <td class="p-10">
                            {{ item.reserve_validity_period || '...' }}
                        </td>
                    </template>
                    <template #Срок_поставки="{item}">
                        <td class="p-10">
                            {{ item.delivery_time || '...' }}
                        </td>
                    </template>
                    <template #Отгружен="{item}">
                        <td class="p-10">
                            {{ item.isShipped ? 'Да' : 'Нет' }}
                        </td>
                    </template>
                    <template #Номер_счёта="{item}">
                        <td class="p-10">
                            {{ item.invoice_number || '...' }}
                        </td>
                    </template>
                </TableV>
            </template>
        </TableV>
    </div>
</template>

<script>
import inputV from "@/components/inputV.vue";
import selectV from "@/components/selectV.vue";
import TableV from "@/components/TableV.vue";
import checkboxV from "@/components/checkboxV.vue";
import buttonV from "@/components/buttonV.vue";
import Modal from "@/components/Modal.vue";
import Toast from "@/components/Toast.vue";
import {useAppStore} from '@/stores/AppStore.js';
import {mapActions, mapState} from 'pinia';
import { useToast } from "vue-toastification";

export default {
    name: "OrdersPage",
    data() {
      return {
          orders: [],
          toast: useToast(),
      }
    },
    methods: {
        async getOrders() {
            const response = await axios.get('/order');
            this.orders = response.data;
        },
        async changeStatus(order_id, newStatus) {
            await axios.put(`/order/${order_id}`, {status: newStatus});
        },
        async updateOrdersData() {
            try {
                const formData = new FormData(this.$refs.importForm);
                await axios.post('/order/importOrders', formData);
                this.getOrders();
                this.toast({
                    component: Toast,
                    props: {
                        title: "Импорт успешно завершён",
                        text: `Новые цены установлены, вы можете изменить статусы заказов`,
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
                this.$refs.importOrdersDataModal.close();
                this.$refs.importForm.reset();
            }
        },
        exportSelectedOrders() {
            let params='?';
            this.orders.forEach(order => order.selected ? params+=`order_id[]=${order.id}&` : false);
            window.location = `/order/exportOrders/${params.slice(0,-1)}`;
        },
        ...mapActions(useAppStore, ["firstLoad"]),
    },
    computed: {
        isSomeSelected() {
            return this.orders.some(order => order.selected)
        },
        ...mapState(useAppStore, ['FirstLoading']),
    },
    watch: {
        orders(newOrders, oldOrders) {
            if (newOrders.length) {
                // Поскольку после обновления orders теряют selected, восстанавливаем их для каждого
                newOrders.forEach(order => order.selected = oldOrders.find(oldOrder => oldOrder.id == order.id)?.selected || false);
            }
        }
    },
    mounted() {
        this.firstLoad(this.getOrders);
    },
    components: {
        Modal,
        checkboxV,
        inputV,
        selectV,
        TableV,
        buttonV,
    },
}
</script>
