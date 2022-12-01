<template>
    <app-layout>
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
            <add-item-modal>
                <template #title>
                    <h2>Items in this Campaign Box</h2>
                </template>
                <template #content> 
                    <div class="flex">                           
                        <button class=" mr-3 justify-end text-white-500 bg-violet-600 font-bold px-3 py-2 text-white outline-none focus:outline-none mr-1 mb-1 rounded ease-linear transition-all duration-150" @click="addItem">Agregar item </button>
                        {{form.items}}
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
            </add-item-modal>
        </div>
        <div class="flex justify-end">
            <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="store"> Crear</button>
        </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";
import AddItemModal from '@/Jetstream/AddItemModal.vue';
import axios from 'axios'

export default {
    components: {
        AppLayout,
        Input,
        AddItemModal,
    },
    props: {
        items: {
            type: Object
        }       
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
                users: []
            }
        }
    },
    methods:{
        addItem(){
            this.form.items.push({id:'', count:{}})
        },
        removeItem(index){
            this.form.items.splice(index, 1)
        },
        store(){
            axios.post(this.route('campaigns.store'),this.form)
            .then(res => {
                console.log(res)
            })
            .catch(err => {
                console.error(err); 
            })
            // this.$inertia.post(this.route('campaigns.store'), this.form);
        }
    }
}
</script>

<style>

</style>