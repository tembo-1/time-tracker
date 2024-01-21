<template>
    <header class="py-20 bg-malachite-tech-pattern bg-[center_-305px] bg-no-repeat bg-cover" style="box-shadow: 0 3px 5px #888888">
        <div class="container flex">
            <a href="/" class="flex-shrink-0">
                <img src="/img/Logo(full).svg" class="logo h-80" alt="Sendis">
            </a>
            <div class="flex flex-col w-full gap-y-20">
                <div class="flex gap-x-60 relative" :class="[Auth ? 'justify-end' : 'justify-center']">
                    <form action="" class="text-sm rounded-5 px-15 flex gap-x-15 bg-light-gray text-dark h-40" style="box-shadow: inset 0 0 5px 1px #888888">
                        <iconV name="loupe" class="fill-gray" />
                        <selectV name="searchCategory" id="searchSelect" class="bg-transparent focus-visible:ring-0 border-0 text-sm">
                            <option value="" selected>Каталог</option>
                            <option value="">Запросы</option>
                            <option value="">Счета/Резервы</option>
                            <option value="">Грузы</option>
                        </selectV>
                        <inputV type="text" name="searchValue" placeholder="Поиск..." class="bg-transparent focus-visible:ring-0 border-0 text-sm h-40 w-[200px]" />
                    </form>
                    <div v-if="Auth" class="flex items-center gap-20 text-white">
                        <buttonV icon="dollar" icon-classes="w-30 p-5" aria-label="Узнать курс валют" title="Курс валют" class="p-0 hover:scale-125 duration-200" />
                        <buttonV icon="star" icon-classes="w-30 p-5" aria-label="Перейти в раздел 'избранное'" title="Избранное" class="p-0 hover:scale-125 duration-200" />
                        <buttonV icon="bell" icon-classes="w-30 p-5" aria-label="Посмотреть уведомления" title="Уведомления" class="p-0 hover:scale-125 duration-200" />
                        <buttonV icon="truck" icon-classes="w-40 p-5" aria-label="Перейти в раздел 'отгрузки'" title="Отгрузки" class="p-0 hover:scale-125 duration-200" />
                        <a v-if="UserData.role === 'User'" href="/cart" class="relative hover:scale-125 duration-200" aria-label="Перейти в раздел 'корзина'" title="Корзина">
                            <badge v-if="CartCount" class="absolute top-0 right-0" :value="CartCount" />
                            <iconV name="cart" class="w-30 p-5" />
                        </a>
                    </div>
                    <div v-if="Auth" class="flex items-center">
                        <buttonV id="userDropdownInformationButton" data-dropdown-toggle="userDropdownInformation" type="button"
                            class="text-white flex-row-reverse px-0 gap-x-10 cus-bottom-underline rounded-none py-5" icon="user" :text="UserData.login" />

                        <!-- Dropdown menu -->
                        <div id="userDropdownInformation" class="max-w-[200px] z-50 hidden bg-white divide-y divide-gray rounded-5 shadow">
                            <div class="p-10">
                                <div>{{ UserData.login }}</div>
                                <div class="font-medium truncate">{{ UserData.info?.email }}</div>
                            </div>
                            <ul class="py-10" aria-labelledby="userDropdownInformationButton">
                                <li>
                                    <a href="#" class="block px-10 py-5 hover:bg-gray/50">Личный кабинет</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-10 py-5 hover:bg-gray/50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-10 py-5 hover:bg-gray/50">Earnings</a>
                                </li>
                            </ul>
                            <div class="py-10">
                                <a href="/logout" class="block cursor-pointer px-10 py-5 hover:bg-gray/50">Выйти</a>
                            </div>
                        </div>
                    </div>
                    <a v-else href="/login"
                        class="absolute right-0 top-[50%] translate-y-[-50%] flex justify-self-end items-center gap-x-5 text-white hover:text-main-light-green duration-200">
                        Войти
                        <iconV name="door-open" class="p-5 w-30" />
                    </a>
                </div>
                <div class="flex justify-center gap-x-40 text-white text-base h-20">
                    <a href="/catalog" class="cus-bottom-underline">
                        Каталог
                    </a>
                    <a v-if="UserData.role === 'User'" href="/orders" class="cus-bottom-underline">
                        Мои запросы
                    </a>
                    <a v-if="Permitted('order.view')" href="/manager/orders" class="cus-bottom-underline">
                        Запросы
                    </a>
                    <a v-if="Permitted('request.view')" title="Заявки на регистрацию" href="/manager/requests" class="cus-bottom-underline">
                        Заявки
                    </a>
                    <a v-if="UserData.role === 'User'" href="/cart" class="cus-bottom-underline">
                        Создать запрос
                    </a>
                    <a href="/help" class="cus-bottom-underline">
                        Помощь
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import iconV from '@/components/iconV.vue';
import selectV from '@/components/selectV.vue';
import inputV from '@/components/inputV.vue';
import buttonV from "@/components/buttonV.vue";
import {useUserStore} from '@/stores/UserStore.js';
import {mapActions, mapState} from 'pinia';
import badge from "@/components/badge.vue";
import { Dropdown } from 'flowbite';

export default {
    methods: {
        ...mapActions(useUserStore, ['Permitted'])
    },
    computed: {
        ...mapState(useUserStore, ['Auth', "UserData", "CartCount"]),
    },
    components: {
        badge,
        iconV,
        selectV,
        inputV,
        buttonV,
    },
    mounted() {
        useUserStore().getCartCount();
    }
}
</script>

