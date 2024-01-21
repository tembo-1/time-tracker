<template>
    <div class="container flex flex-col justify-center items-center py-60 gap-y-60">
        <a href="/"><img src="/img/Logo(full).svg" class="logo w-[210px]" alt="Logo"></a>
        <form id="loginForm" method="POST" class="flex flex-col items-center white-substrate gap-y-30" @submit.prevent="Login">
            <div class="flex flex-col items-center">
                <h1 class="text-center">Войти</h1>
                <span class="text-xs">или</span>
                <a href="/registration" class="text-xs cus-link">зарегистрироваться</a>
            </div>
            <inputV placeholder="Логин" name="login" class="w-[300px] inp-light-gray" />
            <div class="flex flex-col gap-y-15">
                <inputV placeholder="Пароль" name="password" type="password" class="w-[300px] inp-light-gray" />
                <a href="#" class="w-fit text-xs cus-link">Восстановление пароля</a>
            </div>

            <div v-if="message" class="text-error text-xs">{{ message }}</div>

            <buttonV text="Вход" type="submit" icon="door-open" class="btn-white-bordered" />
        </form>
    </div>
</template>

<script>
import inputV from '@/components/inputV.vue';
import buttonV from '@/components/buttonV.vue';
import {useAppStore} from "@/stores/AppStore.js";
import {mapActions} from "pinia";

export default {
    data() {
        return {
            page: "Authorisation",
            message: '',
        }
    },
    methods: {
        async Login() {
            const form = document.getElementById('loginForm');
            const formData = new FormData(form);

            try {
                const response = await axios.post('/login', formData);

                if (response.status == 200){
                    window.location = '/';
                }

            } catch (error) {
                if (error.response.status == 422) {
                    this.setValidationErrors(error.response.data.errors);
                } else if (error.response.status == 403) {
                    this.message = error.response.data.message;
                    setTimeout(() => this.message = '', 3000);
                }
            }

        },
        ...mapActions(useAppStore, ["setValidationErrors"]),
    },
    components: {
        inputV,
        buttonV,
    }
}
</script>
