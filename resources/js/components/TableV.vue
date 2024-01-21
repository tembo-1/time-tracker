<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-left">
            <thead>
            <tr class="border-b border-gray/50" :class="trAdditionalClasses">
                <th v-for="column in shownColumns" scope="col" class="px-10 py-15" :class="column.class">
                    <div class="flex items-center gap-x-10">
                        <p>{{ column.title }}</p>
                        <div v-if="column.sortField" class="flex flex-col text-[10px] leading-none">
                            <span role="button" title="По возрастанию" class="cursor-pointer hover:text-main-green" :class="{'text-main-green' : sortDirection === 'asc' && sortField === column.sortField}" @click="sortHandler(column.sortField, 'asc')">▲</span>
                            <span role="button" title="По убыванию" class="cursor-pointer hover:text-main-green" :class="{'text-main-green' : sortDirection === 'desc' && sortField === column.sortField}" @click="sortHandler(column.sortField, 'desc')">▼</span>
                        </div>
                    </div>
                </th>
                <th v-if="withCollapse && !loading" scope="col" class="px-10 py-15"></th>
            </tr>
            </thead>
            <tbody>
            <template v-if="!loading && !withCollapse">
                <tr v-for="(item, ind) in sortedData" class="border-b border-gray/50 hover:bg-light-gray duration-200" :class="trAdditionalClasses">
                    <slot v-for="column in shownColumns" :name="column.title.replace(/\s+/g, '_')" :item="item" :index="ind">
                        <td></td>
                    </slot>
                </tr>
            </template>

            <template v-if="!loading && withCollapse" v-for="(item, ind) in sortedData">
                <tr class="border-b border-gray/50 hover:bg-light-gray duration-200" :class="trAdditionalClasses">
                    <slot v-for="column in columns" :name="column.title.replace(/\s+/g, '_')" :item="item" :index="ind">
                        <td></td>
                    </slot>
                    <td class="p-10 w-50"><buttonV :icon="openCollapses[item.id || ind] ? 'chevron-top' : 'chevron-down'" class="p-0 h-30 w-30" @click="toggleCollapse(item.id || ind)" /></td>
                </tr>
                <tr>
                    <td :colspan="columns.length + 1" class="p-0">
                        <Collapse :when="openCollapses[item.id || ind]">
                            <slot name="collapseContent" :item="item"></slot>
                        </Collapse>
                    </td>
                </tr>
            </template>


            <!-- Скелетики 💀💀 -->
            <tr v-if="loading" v-for="item in 10" class="border-b border-gray/50 hover:bg-light-gray duration-200" :class="trAdditionalClasses">
                <td v-for="column in shownColumns" class="p-10">
                    <span class="w-full h-15 pulsing-frame"></span>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="text-center text-xl py-50" v-if="!data.length && !loading">{{emptinessMessage}}</p>
    </div>
</template>

<script>
import buttonV from "@/components/buttonV.vue";
import { Collapse } from "vue-collapsed";

export default {
    name: "TableV",
    data() {
        return {
            openCollapses: {},
            sortDirection: null,
            sortField: null,
        }
    },
    methods: {
        toggleCollapse(index) {
            this.openCollapses[index] = !this.openCollapses[index];
        },
        sortHandler(sortField, sortDirection) {
            if (sortDirection === this.sortDirection && sortField === this.sortField) {
                this.sortDirection = null;
                this.sortField = null;
            } else {
                this.sortDirection = sortDirection;
                this.sortField = sortField;
            }
        },
    },
    components: {buttonV, Collapse},
    props: {
        columns: {
            type: Array,
            required: true,
            validator(array) {
                return array.every(item => 'title' in item);
            }
        },
        data: Array,
        loading: Boolean,
        trAdditionalClasses: String,
        emptinessMessage: {
            type: String,
            default: "Нет результатов",
        },
        withCollapse: Boolean,
    },
    computed: {
        shownColumns() {
            return this.columns.filter(col => !col.hidden)
        },
        sortedData() {
            if (this.sortField) {
                return [...this.data].sort((row1, row2) => {
                    let value1 = row1[this.sortField];
                    let value2 = row2[this.sortField];
                    if (isNaN(value1.replaceAll(' ', '')) || isNaN(value2.replaceAll(' ', ''))) {
                        // Если значения не числовые, используем лексикографическую сортировку
                        if (this.sortDirection === 'asc') {
                            return value1.localeCompare(value2);
                        } else {
                            return value2.localeCompare(value1);
                        }
                    } else {
                        // Если значения числовые, сортируем как числа
                        value1 = parseFloat(value1.replaceAll(' ', ''));
                        value2 = parseFloat(value2.replaceAll(' ', ''));
                        if (this.sortDirection === 'asc') {
                            return value1 - value2;
                        } else {
                            return value2 - value1;
                        }
                    }
                });
            }
            return this.data
        }
    },
}
</script>
