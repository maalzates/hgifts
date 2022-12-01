<template>
  <app-layout>
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Campaigns List
          </h2>
            <Link  :href="route('campaigns.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Create New</Link>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dispatch Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suscribed</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Iterating through campaign records rendered as a table -->
                                <tr v-for="campaign in campaigns.data" :key="campaign.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.status}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <dialog-modal>
                                            <template #title>
                                                <h1> Items in this box </h1>
                                            </template>
                                            <template #content >
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr v-for="item in campaign.items" :key="item.id">
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.name}}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.pivot.count}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                            </template>
                                            <template #footer>
                                            </template>

                                        </dialog-modal>

                                        <!-- USO de lista HTML para mostrar los items de cada campaña -->
                                        <!-- <ol v-for="item in campaign.items" :key="item.id" >
                                            <li><p>{{item.name}}</p></li>
                                        </ol> -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.dispatch_date}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.delivery_date}}
                                    </td>
                                    <!-- SUSCRIBED USERS MODAL -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <users-modal>
                                            <template #title>
                                                <h1> Items in this box </h1>
                                            </template>
                                            <template #content >
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr v-for="user in campaign.users" :key="user.id">
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{user.name}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                            </template>
                                            <template #footer>
                                            </template>
                                        </users-modal>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-chevron-right"></i>
                                        </Link>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>

                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import DialogModal from '@/Jetstream/DialogModal.vue';
import UsersModal from '../Components/UsersModal.vue';

export default {
    components: {
        AppLayout,
        Link,
        DialogModal,
        UsersModal
    },
    props: {
        campaigns: {
            type: Object
        }
    },
}
</script>

<style>
    body{
        overflow-x: hidden;
    }
</style>