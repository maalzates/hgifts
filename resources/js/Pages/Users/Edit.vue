<template>
    <app-layout :is_admin="this.is_admin">
        <template #header>
            Assign roles to {{user.name}}
        </template>
        <div class="flex justify-center mt-2">
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">User: {{user.name}}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400 mb-2 ">Change roles for this user</p>
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
            </div>
        </div>
    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import { mapActions } from 'vuex';
import {areOptionsEmpty, userRolesUpdated, emptyOptionsError} from '../Helpers/users.js'

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
        ...mapActions('users', ['updateUserRoles']),
        update(){
            const data = {
                user: this.user,
                roles: this.form
            };
            if(areOptionsEmpty(this.form.roles)){
                emptyOptionsError(this.$swal);
            }else {
                this.updateUserRoles(data).then( () => {
                    userRolesUpdated(this.$swal);
                });

            }

        }
    }
}
</script>

<style>

</style>