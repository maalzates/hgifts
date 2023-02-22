<template>
<app-layout>

  <template #header>
          <div class="flex justify-between">
          <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Users list
          </h2>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th scope="col" class="px-6 py-3 text-medium text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Roles
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{user.name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{user.email}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{user.address}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-center">
                                        <Link :href="route('users.edit', user)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-regular fa-pen-to-square"></i>
                                        </Link>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>

                            
                        </table>
                        <pagination :pagination="items" />
                    </div>
                </div>
            </div>
        </div>
</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components:{
        AppLayout,
        Link
    },
    props: {
        users: {
            type: Object,
        }
    }
}
</script>

<style>

</style>