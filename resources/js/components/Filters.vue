<template>
    <form class="flex flex-col gap-y-20">
        <inputV placeholder="Критерии поиска" name="search" v-model="searchValue" autocomplete="off" icon="loupe" class="inp-white w-full" @button-click="emitSearch" @clean="emitClean" />
        <div class="white-substrate flex flex-col gap-y-20 development">
            <h4 class="text-xl">Фильтры</h4>
            <selectV name="category" class="inp-white-bordered w-full">
                <option value="" selected>Все категории</option>
                <option value="">Категория 1</option>
                <option value="">Категория 2</option>
            </selectV>
            <selectV name="vendor" class="inp-white-bordered w-full">
                <option value="" selected>Все вендоры</option>
                <option value="">Венндор 1</option>
                <option value="">Венндор 2</option>
            </selectV>
            <checkboxV label="Гейминг" name="forGaming" />
            <checkboxV label="Минпромторг РФ" name="minProm" />
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Цена, руб.</span>
                <div class="flex gap-x-20">
                    <input-v class="inp-white-bordered w-[120px]" placeholder="От" name="minPrice" />
                    <input-v class="inp-white-bordered w-[120px]" placeholder="До" name="maxPrice" />
                </div>
            </div>
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Наличие</span>
                <checkboxV label="Доступно на складе" name="inStock" />
                <checkboxV label="Доступно в транзите" name="inTransit" />
            </div>
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Раздел</span>
                <radioV label="В каталоге" name="section" id="sectionRadio1" value="inCatalog" checked />
                <radioV label="По заказным позициям" name="section" id="sectionRadio2" value="orderedPositions" />
                <radioV label="Демо оборудование" name="section" id="sectionRadio3" value="demo" />
                <radioV label="Запчасти" name="section" id="sectionRadio4" value="spares" />
            </div>
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Спецпредложения</span>
                <radioV label="Весь товар" name="specialOffer" id="specialOfferRadio1" value="all" checked />
                <radioV label="Акция дня" name="specialOffer" id="specialOfferRadio2" value="dayPromo" />
            </div>
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Показать некондицию</span>
                <radioV label="Да" name="substandard" id="substandardRadio1" value="true" checked />
                <radioV label="Нет" name="substandard" id="substandardRadio2" value="false" />
                <radioV label="Только некондиция" name="substandard" id="substandardRadio3" value="only" />
            </div>
            <div class="flex flex-col gap-y-10">
                <span class="w-full font-semibold">Показать Демо</span>
                <radioV label="Да" name="demo" id="demoRadio1" value="true" checked />
                <radioV label="Нет" name="demo" id="demoRadio2" value="false" />
                <radioV label="Только демо-оборудование" name="demo" id="demoRadio3" value="only" />
            </div>
        </div>
    </form>
</template>

<script>
import inputV from '@/components/inputV.vue';
import checkboxV from '@/components/checkboxV.vue';
import selectV from '@/components/selectV.vue';
import radioV from "@/components/radioV.vue";
import {useAppStore} from "@/stores/AppStore.js";
import {mapWritableState} from "pinia";
export default {
    data() {
        return {
            searchValue: '',
        }
    },
    methods: {
        emitSearch() {
            if (this.searchValue && this.searchValue !== this.Params.search) {
                this.$emit('search', this.searchValue.trim());
            } else if (!this.searchValue && this.Params.search) {
                this.emitClean();
            }
        },
        emitClean() {
            this.$emit('search-clean');
        }
    },
    computed: {
        ...mapWritableState(useAppStore, ["Params"]),
    },
    watch: {
        Params(newParams) {
            this.searchValue = newParams.search;
        }
    },
    emits: ['search', 'search-clean'],
    components: {
        inputV,
        checkboxV,
        selectV,
        radioV,
    },
}
</script>
