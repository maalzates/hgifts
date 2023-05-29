<template>
    <app-layout :is_admin="this.is_admin">
        <template #header>
            Assign roles to {{user.name}}
        </template>
        <div class="flex items-center mb-4">
            <input v-model="form.roles" id="admin" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Admin</label>
        </div>
        <div class="flex items-center">
            <input v-model="form.roles" checked id="regular" type="checkbox" value="2" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Regular</label>
        </div>
        <div class="flex justify-start">
            <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="update"> Update </button>
        </div>
    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    components: {
        AppLayout,
    },
    props: {
        user: {
            type: Object,
        },
        roles: {
            type: Object,
        },
        is_admin: {
            type: Boolean,
        },
    },
    data() {
        return {
            form:{
                roles: [...this.roles],
            },

        }
    },
    methods:{
        update(){
            console.log('sending');
            this.$inertia.put(this.route('users.update', this.user), this.form);
        }
    }
}
</script>

<style>

</style>