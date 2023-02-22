<template>
  <app-layout title="Items">
        <template #header>
          <div class="flex justify-between">
          <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Items List
          </h2>
            <Link :href="route('items.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" v-if="can('items.create')"> Create New</Link>
          </div>
        </template>
        <!-- Item Listing -->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <!-- <div class="px-6 py-4 flex items-center">
                            <Input v-model="search" type="text" class="flex-1" placeholder="Ingres texto para filtrar" />
                            <Link :href="route('contacts.create')" class="ml-4 flex-shrink-0 btn btn-blue">Nuevo</Link>
                        </div> -->

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units Owned</th>
                                    <th v-if="can('items.edit')" scope="col" class="relative px-6 py-3">
                                        <span class="sr-only" >Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in items.data" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{item.name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{item.unit_price}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{item.units_owned}}
                                    </td>
                                    <td v-if="can('items.edit')" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('items.edit', item)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-regular fa-pen-to-square"></i>
                                        </Link>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>

                            
                        </table>
                        <Pagination :pagination="items" />
                    </div>
                </div>
            </div>
        </div>
        
  </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from "../Components/Pagination.vue";

export default {
    components: {
        AppLayout,
        Link,
        Pagination
    },
    props: {
      items: {
        type: Object,
      },
      methods: {
      }
    },

}
</script>

<style>

</style>