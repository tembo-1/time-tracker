<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Мои запросы</h1>
        <TableV :loading="FirstLoading" with-collapse class="white-substrate text-sm" :columns="[
            {title:'Номер'},
            {title:'Статус'},
            {title:'Тип'},
            {title:'Цель'},
            {title:'Заказчик'},
            {title:'Время на обработку'},
            {title:'Срок поставки'},
            {title:'Требуется резерв'},
            {title:'Время создания'},
            {title:'↓', class: 'opacity-0'},
                ]" :data="orders" emptiness-message="Вы ничего не заказывали">
            <template #Номер="{item: order}">
                <td class="p-10">
                    #{{ order.id }}
                </td>
            </template>
            <template #Статус="{item: order}">
                <td class="p-10">
                    {{ order.status }}
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
            <template #Заказчик="{item: order}">
                <td class="p-10">
                    {{ order.info.customer }}
                </td>
            </template>
            <template #Время_на_обработку="{item: order}">
                <td class="p-10">
                    {{ order.processingTime || order.implementationTime }}
                </td>
            </template>
            <template #Срок_поставки="{item: order}">
                <td class="p-10 max-w-[250px]">
                    {{ order.info.deliveryConditions }}
                </td>
            </template>
            <template #Требуется_резерв="{item: order}">
                <td class="p-10">
                    {{ order.info.createReserve ? 'Да' : 'Нет' }}
                </td>
            </template>
            <template #Время_создания="{item: order}">
                <td class="p-10">
                    {{ order.created_at }}
                </td>
            </template>
            <template #↓="{item: order}">
                <td class="p-10">
                    <a :href="`/order/exportOrders?order_id[]=${order.id}`" title="Скачать excel">
                        <buttonV icon="download" class="p-10 btn-gray-hovered-dark" />
                    </a>
                </td>
            </template>
            <template #collapseContent="{item: order}">
                <TableV class="px-20 text-xs max-w-[1400px]" tr-additional-classes="!border-gray" :columns="[
                    {title:'#'},
                    {title:'Наименование'},
                    {title:'Артикул'},
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
                        <td class="p-10 max-w-[400px] break-words">
                            {{ item.name }}
                        </td>
                    </template>
                    <template #Артикул="{item}">
                        <td class="p-10">
                            {{ item.article }}
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
                            {{ item.quantity_manager || '...' }}
                        </td>
                    </template>
                    <template #Кол-во_в_транзите="{item}">
                        <td class="p-10">
                            {{ item.transit_manager || '...' }}
                        </td>
                    </template>
                    <template #Дата_транзита="{item}">
                        <td class="p-10">
                            {{ item.transitdate_manager || '...' }}
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
import {mapActions, mapState} from "pinia";
import {useAppStore} from "@/stores/AppStore.js";

export default {
    name: "OrdersPage",
    data() {
      return {
          orders: [],
      }
    },
    methods: {
        async getOrders() {
            const response = await axios.get('/order');
            this.orders = response.data;
        },
        ...mapActions(useAppStore, ["firstLoad"]),
    },
    computed: {
        ...mapState(useAppStore, ["FirstLoading"]),
    },
    mounted() {
        this.firstLoad(this.getOrders);
    },
    components: {
        checkboxV,
        inputV,
        selectV,
        TableV,
        buttonV,
    },
}
</script>
