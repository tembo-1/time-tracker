<template>
    <div class="container flex flex-col justify-center items-center py-60 gap-y-60">
        <a href="/"><img src="/img/Logo(full).svg" class="logo w-[210px]" alt="Logo"></a>
        <form ref="form" id="registrationForm" method="POST" class="flex flex-col items-center white-substrate gap-y-30 w-[460px]">
            <div class="flex flex-col items-center">
                <h1 class="text-center">Регистрация</h1>
                <span class="text-xs">или</span>
                <a href="/login" class="text-xs cus-link">авторизация</a>
            </div>

            <Stepper class="flex flex-col gap-y-20 w-full">
                <template #step1>
                    <strong>Подтвердите, что:</strong>
                    <checkboxV label="Ваша организация планирует приобретение ИТ-продукции для дальнейшей перепродажи" name="agreement1"/>
                    <checkboxV label="Вы действуете от имени и в интересах представляемой компании" name="agreement2"/>
                    <checkboxV label="Вы готовы предоставить юридическую и налоговую информацию об организации в случае такой необходимости" name="agreement3"/>
                    <checkboxV label="Вы подтверждаете согласие с условиями договра-оферты, действующем в пределах лимитов закупки" name="agreement4"/>
                </template>
                <template #step2>
                    <b>О пользователе</b>
                    <inputV class="inp-light-gray w-full" placeholder="Фамилия" name="surname"/>
                    <inputV class="inp-light-gray w-full" placeholder="Имя" name="firstName"/>
                    <inputV class="inp-light-gray w-full" placeholder="Отчество" name="patronymic"/>
                    <inputV class="inp-light-gray w-full" placeholder="E-mail" type="email" name="email"/>
                    <inputV class="inp-light-gray w-full" placeholder="Мобильный телефон" type="tel" name="phone"/>
                    <checkboxV label="Я соглашаюсь на обработку моих персональных данных" name="personalAgreement" />
                </template>
                <template #step3>
                    <b>О компании</b>
                    <inputV class="inp-light-gray w-full" placeholder="Название компании" name="organisation"/>
                    <selectV class="inp-light-gray" name="region">
                        <option value="" selected disabled>Регион</option>
                        <option :value="region.id" v-for="region in Regions">{{region.name}}</option>
                    </selectV>
                    <inputV class="inp-light-gray w-full" placeholder="Город" name="city"/>
                    <inputV class="inp-light-gray w-full appearance-none" placeholder="ИНН" type="number" name="inn"/>
                    <inputV class="inp-light-gray w-full appearance-none" placeholder="БИК" type="number" name="bik"/>
                    <inputV class="inp-light-gray w-full appearance-none" placeholder="Расчётный счет" type="number" name="checkingAccount"/>
                    <inputV class="inp-light-gray w-full" placeholder="E-mail для обмена бух. документами" name="accountingEmail"/>
                    <inputV class="inp-light-gray w-full" placeholder="Сайт компании" name="site"/>
                </template>
                <template #step4>
                    <h3 class="text-center text-2xl">Ваша заявка отправлена</h3>
                    <p class="text-center">Ожидайте дальнейших инструкций в письме, оно придёт на указанную почту</p>
                </template>
                <template #buttons="{step, steps, nextStep, previousStep}">
                    <div class="grid grid-cols-3 gap-x-20 w-full">
                        <buttonV class="btn-white-bordered col-span-1" text="Назад" v-if="step > 1 && step !== steps" @click="previousStep"/>
                        <buttonV class="btn-white-bordered col-start-3" text="Далее" v-if="step < steps - 1" @click="onNextStep(nextStep, step)"/>
                        <buttonV class="btn-green col-start-2 col-end-4 ms-auto w-fit" text="Зарегистрироваться" v-if="step === steps - 1" @click="onNextStep(nextStep, step)"/>
                        <a href="/" class="btn btn-green col-span-3 mx-auto w-fit" v-if="step === steps">Готово</a>
                    </div>
                </template>
            </Stepper>
        </form>
    </div>
</template>

<script>
import Stepper from "@/components/Stepper.vue";
import inputV from "@/components/inputV.vue";
import buttonV from "@/components/buttonV.vue";
import checkboxV from "@/components/checkboxV.vue";
import selectV from "@/components/selectV.vue";
import {useAppStore} from "@/stores/AppStore.js";
import {mapActions, mapState, mapWritableState} from "pinia";

export default {
    name: "RegistrationPage",
    data() {
        return{
            steps: {},
        }
    },
    methods: {
        initSteps() {
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                const inputs = section.querySelectorAll('select, input');
                this.steps[index+1] = Array.from(inputs).map(input => input.name);
            })
        },
        async onNextStep(nextStepFunc, currentStep) {
            try {
                const formData = new FormData(this.$refs.form);
                await axios.post('/registration', formData);
                nextStepFunc()
            } catch (error) {
                if (error.response.status === 422) {
                    const allValidationErrorsKeys = Object.keys(error.response.data.errors);
                    if (allValidationErrorsKeys.some(error => this.steps[currentStep].includes(error))){
                        this.setValidationErrors(error.response.data.errors);
                    } else {
                        this.ValidationErrors = {};
                        nextStepFunc();
                    }
                }
            }
        },
        ...mapActions(useAppStore, ['getRegions', "firstLoad", "setValidationErrors"]),
    },
    computed: {
        ...mapWritableState(useAppStore, ["ValidationErrors"]),
        ...mapState(useAppStore, ["Regions"]),
    },
    mounted() {
        this.initSteps();
        this.firstLoad(this.getRegions);
    },
    components: {
        selectV,
        checkboxV,
        buttonV,
        inputV,
        Stepper
    },
}
</script>
