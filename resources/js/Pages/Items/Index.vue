<template>
    <app-layout title="Items" :is_admin="this.is_admin">
        <template #header>
          <div class="flex justify-between">
          <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Items List
          </h2>
            <Link :href="route('items.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" v-if="this.is_admin"> Create New</Link>
          </div>
        </template>
        
        <!-- Item Listing -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            NAME
                        </th>
                        <th scope="col" class="px-6 py-3">
                            UNIT PRICE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            UNITS OWNED
                        </th>
                        <th scope="col" class="px-6 py-3">
                            EDIT
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items.data" :key="item.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{item.name}}
                        </th>
                        <td class="px-6 py-4">
                            {{item.unit_price}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.units_owned}}
                        </td>
                        <td v-if="this.is_admin" class="px-6 py-4">
                            <Link :href="route('items.edit', item)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-center">
            <TailwindPagination :data="items" @pagination-change-page="fetchItems"/>
        </div>
    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';
import { mapActions, mapState } from 'vuex';
import { TailwindPagination } from 'laravel-vue-pagination';


export default {
    components: {
        AppLayout,
        Link,
        TailwindPagination
    },
    data(){
        return {

        }
    },
    computed: {
        ...mapState('items', ['items', 'is_admin'])
    },
    created(){
        this.fetchItems();
    },
    methods:{
        ...mapActions('items', ['fetchItems'])
    }

}
</script>

<style>

</style>