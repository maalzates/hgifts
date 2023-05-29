<template>
<app-layout :is_admin="this.is_admin">
  <template #header>
          <div class="flex justify-between">
          <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Users list
          </h2>
          </div>
        </template>
        <!-- Users Listing -->
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                           NAME
                        </th>
                        <th scope="col" class="px-6 py-3">
                            EMAIL
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ADDRESS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            EDIT ROL
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" >
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{user.name}}
                        </th>
                        <td class="px-6 py-4">
                            {{user.email}}
                        </td>
                        <td class="px-6 py-4">
                            {{user.address}}
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('users.edit', user)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-center align-center">
                <TailwindPagination :data="users" @pagination-change-page="fetchUsers" />
            </div>
        </div>
</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';
import { mapActions, mapState } from 'vuex';
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    components:{
        AppLayout,
        Link,
        TailwindPagination
    },
    computed: {
        ...mapState('users', ['users'])
    },
    created(){
        this.fetchUsers();
    },
    methods: {
        ...mapActions('users',['fetchUsers'])
    },
}
</script>

<style>

</style>