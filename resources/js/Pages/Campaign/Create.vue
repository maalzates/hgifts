<template>
    <app-layout :is_admin="this.is_admin">
    <template #header>
      <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Create New Campaign</h2>
    </template>
    <!-- Create form -->
    <div class="bg-white px-6 py-8 rounded-lg shadow">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <!-- Name -->
                <label>
                    Name
                    <Input v-model="form.name" type="text" class="w-full"/>
                </label>
            </div>
            <div>
                <!-- Status -->
                <label>
                    Status
                <select v-model="form.status" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="preparing">Preparing</option>
                    <option value="ready">Ready</option>
                    <option value="dispatched">Dispatched</option>
                    </select>
                <!-- <span>Selected: {{ form.status }}</span> -->
                </label>
            </div>
            <div>
                <label>
                    Dispatch Day
                    <Input v-model="form.dispatch_day" type="date" class="w-full"/>

                </label>
            </div>
            <div>
                <label>
                    Delivery Day
                    <Input v-model="form.delivery_day" type="date" class="w-full"/>
                </label>
            </div>
                            <!-- ADD ITEMS {{form.items}} -->
            <AddItemModal>
                <template #title>
                    <h2>Items in this Campaign Box</h2>
                </template>
                <template #content> 
                    <div class="flex">                           
                        <button class=" mr-3 justify-end text-white-500 bg-violet-600 font-bold px-3 py-2 text-white outline-none focus:outline-none mr-1 mb-1 rounded ease-linear transition-all duration-150" @click="addItem">Agregar item </button>
                    </div>
                    <label>
                        <!-- <table v-for="(item, i) in items" :key="i" > -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(form_item, index) in form.items" :key="index">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <select  v-model="form_item.id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                            <option v-for="(item, index) in items" :key="index" :value="item.id"  >{{item.name}} </option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <input type="number" min="0" placeholder="Amount" v-model="form_item.count" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </td>
                                    <td>
                                        <button @click="removeItem(index)">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </label>
                </template>
            </AddItemModal>
            <!-- MultiSelect -->
            <div>
                <VueMultiselect v-model="selected_users" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Add users" label="name" track-by="name" :preselect-first="true">
                    <template><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} Selected Users</span></template>
                </VueMultiselect>
            </div>

        </div>
        <div class="flex justify-end">
            <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="store"> Create new</button>
        </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "@/Jetstream/Input.vue";
import AddItemModal from '@/Jetstream/AddItemModal.vue';
import VueMultiselect from 'vue-multiselect'
import { mapActions } from 'vuex';
import { emptyError, repeatedError, campaignCreated } from '../Helpers/campaigns.js';




export default {
    components: {
        AppLayout,
        Input,
        AddItemModal,
        VueMultiselect
    },
    props: {
        items: {
            type: Object
        },
        users: {
            type: Object
        },
        is_admin: {
            type: Boolean,
        },
    },
    data(){
        return {
            form: {
                name: '',
                status: [],
                items: [
                ],
                dispatch_day: '',
                delivery_day: '',
                users:[]
            },
            selected_users: [],
            options: this.users,
        }
    },
    methods:{
        ...mapActions('campaigns', ['storeCampaign']),
        addItem(){
            this.form.items.push({id:"''", count:""})
        },
        removeItem(index){
            this.form.items.splice(index, 1)
        },
        isDuplicated(){
            // Checking if the items selected are repeated
            let items_array = [...this.form.items].map( (item) => item.id);
            let repeated_items = items_array.some( (item, index) => items_array.indexOf(item) != index);
            return repeated_items;
        },
        isNameOrAmountEmpty(){
            // Check if some of  the selected items is empty
            let items_array = [...this.form.items];
            let validation = items_array.some((item) => Object.values(item).some( value => value === "" ));
            console.log(validation);
            return validation;
        },
        store(){
            // Filtering array of users by id, and attaching to form.
            let uids = this.selected_users.map((user) => user.id);
            this.form.users = uids;

            if (this.isDuplicated()) {
                repeatedError(this.$swal);
            } else if (this.isNameOrAmountEmpty()) {
                emptyError(this.$swal);
            } else {
                this.storeCampaign(this.form).then(() => {
                    campaignCreated(this.$swal);
                })
            }
        }
    }
}
</script>

<style>

</style>