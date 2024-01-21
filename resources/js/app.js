import "./bootstrap";
import "../css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { useAppStore } from "@/stores/AppStore.js";
import Toast, {useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";
import PageLayout from "@/components/PageLayout.vue";
import MainPage from "@/pages/MainPage.vue";
import AuthorisationPage from "@/pages/AuthorisationPage.vue";
import CatalogPage from "@/pages/CatalogPage.vue";
import ProductsPage from "@/pages/ProductsPage.vue";
import CartPage from "@/pages/User/CartPage.vue";
import ManagerOrdersPage from "@/pages/Manager/OrdersPage.vue";
import OrdersPage from "@/pages/User/OrdersPage.vue";
import RegistrationPage from "@/pages/RegistrationPage.vue";
import RegistrationRequestsPage from "@/pages/Manager/RegistrationRequestsPage.vue";
import HelpPage from "@/pages/HelpPage.vue";

const pinia = createPinia();

const app = createApp(PageLayout, getLayoutProps(window.location.pathname));

app.use(pinia);

// axios конфигурируется здесь, а не в bootstrap.js, т.к. для изменения состояния в useAppStore сначала нужно вызвать app.use(pinia)
window.axios.interceptors.request.use(
    (config) => {
        useAppStore().Loading = true;
        return config;
    },
    (error) => {
        useAppStore().Loading = false;
        console.error(error);
        return Promise.reject(error);
    }
);
window.axios.interceptors.response.use(
    (response) => {
        useAppStore().Loading = false;
        return response;
    },
    (error) => {
        useAppStore().Loading = false;
        console.error(error);
        return Promise.reject(error);
    }
);

app.use(Toast, {
    timeout: 3000,
    transition: "Vue-Toastification__fade",
    icon: false,
    closeButton: false,
    containerClassName: "custom-default-toast-container",
    toastClassName: "custom-default-toast",
    filterBeforeCreate
});

// Добавление фичи для закрытия тостов при нажатии на escape
const toastsArray = [];
function filterBeforeCreate (toast, toasts) {
    toastsArray.push(toast.id);
    toast.onClose = () => {
        toastsArray.splice(toastsArray.indexOf(toast.id), 1);
    }
    return toast;
}
window.addEventListener('keyup', (evt) => {
    if (evt.key === 'Escape' && toastsArray.length) {
        useToast().dismiss(toastsArray[0]);
    }
});

// Добавление отступа от хедера
document.addEventListener('DOMContentLoaded', () => {
    const headerNode = document.querySelector('header');
    const fixedTopRightContainer = document.querySelector('.custom-default-toast-container.top-right');

    if (headerNode && fixedTopRightContainer) {
        window.addEventListener('scroll', () => {
            const headerHeight = headerNode.offsetHeight;
            const scrollPosition = window.scrollY;
            fixedTopRightContainer.style.top = Math.max(headerHeight - scrollPosition, 0) + 'px';
        });
    }
})

app.mount("#app");

// Функция, которая возвращает компонент страницы и вариант лейаута в зависимости от текущей страницы
function getLayoutProps(page) {
    switch (page) {
        case "/login":
            document.title = 'Авторизация';
            return {pageComponent: AuthorisationPage, variant: 'minified'} ;
        case "/registration":
            document.title = 'Регистрация';
            return {pageComponent: RegistrationPage, variant: 'minified'} ;
        case "/help":
            document.title = 'Помощь';
            return {pageComponent: HelpPage};
        case "/catalog":
            document.title = 'Категории';
            return {pageComponent: CatalogPage};
        case "/catalog/products":
            document.title = 'Каталог';
            return {pageComponent:ProductsPage};
        case "/cart":
            document.title = 'Корзина';
            return {pageComponent:CartPage};
        case "/orders":
            document.title = 'Мои запросы';
            return {pageComponent:OrdersPage};
        case "/manager/orders":
            document.title = 'Запросы';
            return {pageComponent:ManagerOrdersPage};
        case "/manager/requests":
            document.title = 'Заявки на регистрацию';
            return {pageComponent:RegistrationRequestsPage};
        default:
            return {pageComponent:MainPage};
    }
}
