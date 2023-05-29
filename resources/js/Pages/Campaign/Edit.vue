<template>
    <app-layout :is_admin="this.is_admin">
    <template #header>
      <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Edit Campaign - {{form.name}}</h2>
      <!-- {{this.users}} -->
    </template>
    <!-- Edit form -->
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
                    <option value="preparing"  >Preparing</option>
                    <option value="ready">Ready</option>
                    <option value="dispatched">Dispatched</option>
                    </select>
                <!-- <span>Selected: {{ form.status }}</span> -->
                </label>
            </div>
            <div>
                <label>
                    Dispatch Day {{form.dispatch_date}}
                    <Input v-model="form.dispatch_date" type="date" class="w-full"/>

                </label>
            </div>
            <div>
                <label>
                    Delivery Day {{form.delivery_date}}
                    <Input v-model="form.delivery_date" type="date" class="w-full"/>
                </label>
            </div>
                            <!-- ADD ITEMS {{form.items}} -->
            <AddItemModal>
                <template #title>
                    <h2>Items in this Campaign Box</h2>
                </template>
                <template #content> 
                    <div class="flex">                           
                        <button class=" mr-3 justify-end text-white-500 bg-violet-600 font-bold px-3 py-2 text-white outline-none focus:outline-none mr-1 mb-1 rounded ease-linear transition-all duration-150" @click="addItem">Add item </button>
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
                                        <select  v-model="form_item.item_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
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
                <!-- {{this.form.users}} -->
            </div>
        </div>
        <div class="flex justify-end">
                <button  class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3 mr-3" @click="destroy"> Delete </button>
                <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="update"> Update </button>
        </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";
import AddItemModal from '@/Jetstream/AddItemModal.vue';
import VueMultiselect from 'vue-multiselect';
import { mapActions } from 'vuex';
import { emptyError, repeatedError, fieldsEmptyError, isAnyFieldEmpty, areDuplicatedItems, isNameOrAmountEmpty, campaignUpdatedPopup, campaignDeltedPopup } from '../Helpers/campaigns.js'


export default {
    components: {
        AppLayout,
        Input,
        AddItemModal,
        VueMultiselect
    },
    props: {
        items: { 
          // Is the $campaign->items relationship. An array that includes the pivot key. This contains all items information.
          // This will help us to show the items information dynamically in dropdownbox list and pick up each option value as item.id.
            type: Object
        },
        items_pivot:{
          // Includes only the pivot key from each item record. This will help us to sync the add-items model data.
          type: Object
        },
        campaign:{
          type: Object
        },
        // All available users. This will help us to choose any user we want from the users database in our MultipleSelect Component
        users: {
            type: Object,
        },
        // Only users which are subscribed to this campaign, this will help us to render in the edit view, the input with the already suscribed users selected. 
        users_subscribed: {
            type: Object,
        },
        is_admin: {
            type: Boolean,
        },
    },
    data(){
        return {
            form: {
              ...this.campaign,
              items: this.items_pivot
            },
            options: this.users,
            selected_users: this.users_subscribed,
        }
    },
    methods:{
        ...mapActions('campaigns', ['updateCampaign', 'deleteCampaign']),
        addItem(){
            this.form.items.push({item_id:'', count:''})
        },
        removeItem(index){
            this.form.items.splice(index, 1)
        },
        update(){
            let uids = this.selected_users.map((user) => user.id); // Get all user ids of the curren editing campaign
            this.form.users = uids; // Attaching user id's to the form that will be send in the request. 

            if(isAnyFieldEmpty(this.form)){
                fieldsEmptyError(this.$swal);
            }
            else if (areDuplicatedItems(this.form.items)) {
                repeatedError(this.$swal);
            }else if (isNameOrAmountEmpty(this.form.items)) {
                emptyError(this.$swal);
            } else {
                const data = {
                    current_campaign: this.campaign,
                    updated_campaign: this.form
                };
                this.updateCampaign(data).then( () => { 
                    campaignUpdatedPopup(this.$swal);
                 })
            }
        },
        destroy(){
            this.deleteCampaign(this.campaign).then( () => { 
                campaignDeltedPopup(this.$swal);
             });
        }
    }
}
</script>

<style>

</style>