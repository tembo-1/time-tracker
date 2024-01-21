import { defineStore } from "pinia";

export const useAppStore = defineStore("appStore", {
    state: () => ({
        Loading: false,
        FirstLoading: true,
        Params: {},
        ValidationErrors: {},
        Regions: [],
    }),
    actions: {
        getParams() {
            // Получаем строку с параметрами запроса URL (начиная с "?")
            const queryString = window.location.search;

            // Создаем объект URLSearchParams для разбора параметров
            const searchParams = new URLSearchParams(queryString);

            // Обнуляем состояние (чтобы собрать только актуальные данные)
            this.Params = {};

            // Итерируемся по всем параметрам и добавляем их в params
            searchParams.forEach((value, key) => {
                this.Params[key] = value;
            });

            this.Params.paramsString = '?' + searchParams.toString();

            return this.Params
        },
        pushToHistory() {
            // Создаем новый URL
            const newURL = new URL(window.location.origin + window.location.pathname);

            this.Params.paramsString = null;

            // Добавляем актуальные параметры
            Object.keys(this.Params).forEach(param => {
                if (this.Params[param]){
                    newURL.searchParams.set(param, this.Params[param]);
                }
            })

            this.Params.paramsString = '?' + newURL.searchParams.toString();

            // Используем pushState для изменения URL
            window.history.pushState({}, '', newURL.toString());
        },
        async firstLoad(...methods) {
            try {
                await Promise.all(methods.map(method => method()));
            } catch (error) {
                alert('Ошибка при загрузке данных, страница может работать некорректно');
                console.error(error);
            } finally {
                this.FirstLoading = false;
            }
        },
        setValidationErrors(newValue, resetTime = 3000) {
            this.ValidationErrors = newValue;
            setTimeout(() => this.ValidationErrors = {}, resetTime);
        },
        async getRegions() {
            const response = await axios.get('/regions');
            this.Regions = response.data;
        }
    }
});
