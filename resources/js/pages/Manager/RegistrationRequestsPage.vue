<template>
    <div class="container pb-100">
        <h1 class="text-center my-60">Заявки на регистрацию</h1>

        <TableV :loading="FirstLoading" with-collapse class="white-substrate mt-20" :columns="[
            {title:'Номер'},
            {title:'Дата поступления'},
            ]" :data="requests" emptiness-message="Нет заявок">
            <template #Номер="{item: request}">
                <td class="p-10">
                    #{{ request.id }}
                </td>
            </template>
            <template #Дата_поступления="{item: request}">
                <td class="p-10">
                    {{ request.created_at }}
                </td>
            </template>
            <template #collapseContent="{item: request}">
                <div class="grid grid-cols-3 p-20">
                    <div class="col-span-1 flex flex-col gap-y-20">
                        <b class="text-lg">О пользователе</b>
                        <p><b>Фамилия:</b> {{request.surname}}</p>
                        <p><b>Имя:</b> {{request.firstName}}</p>
                        <p><b>Отчество:</b> {{request.patronymic}}</p>
                        <p><b>E-mail:</b> {{request.email}}</p>
                        <p><b>Мобильный телефон:</b> {{request.phone}}</p>
                    </div>
                    <div class="col-span-1 flex flex-col gap-y-20">
                        <b class="text-lg">О компании</b>
                        <p><b>Регион:</b> {{request.region}}</p>
                        <p><b>Город отгрузки:</b> {{request.city}}</p>
                        <p><b>ИНН:</b> {{request.inn}}</p>
                        <p><b>БИК:</b> {{request.bik}}</p>
                        <p><b>Расчётный счет:</b> {{request.checkingAccount}}</p>
                        <p><b>E-mail для бух. документов:</b> {{request.accountingEmail}}</p>
                        <p><b>Сайт компании:</b> {{request.site}}</p>
                    </div>
                    <div class="col-span-1 flex items-start justify-end gap-x-20">
                        <buttonV class="btn-danger" text="Отклонить" @click="rejectRequest(request.id)" />
                        <buttonV class="btn-green" text="Одобрить" @click="approveRequest(request.id)" />
                    </div>
                </div>
            </template>
        </TableV>
    </div>
</template>

<script>

import buttonV from "@/components/buttonV.vue";
import TableV from "@/components/TableV.vue";
import {mapActions, mapState} from "pinia";
import {useAppStore} from "@/stores/AppStore.js";

export default {
    name: "RegistrationRequestsPage",
    data() {
        return {
            requests: [],
        }
    },
    methods: {
        async getRequests() {
            const response = await axios.get('/request');
            this.requests = response.data;
        },
        async approveRequest(user_id) {
            await axios.put(`/user/${user_id}`, {status: 1});
            this.getRequests();
        },
        async rejectRequest(user_id) {
            await axios.put(`/user/${user_id}`, {status: 0});
            this.getRequests();
        },
        ...mapActions(useAppStore, ["firstLoad"]),
    },
    computed: {
        ...mapState(useAppStore, ['FirstLoading']),
    },
    mounted() {
        this.firstLoad(this.getRequests);
    },
    components: {TableV, buttonV},
}
</script>
