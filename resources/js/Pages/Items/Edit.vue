<template>
    <app-layout :is_admin="this.is_admin">
        <template #header>
            Edit Item
        </template>

        <!-- Edit form -->
        <div class="bg-white px-6 py-8 rounded-lg shadow">
            <jet-validation-errors></jet-validation-errors>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label>
                        Name
                        <Input v-model="form.name" type="text" class="w-full"/>
                    </label>
                </div>
                <div>
                    <label>
                        Unit Price
                        <Input v-model="form.unit_price" type="number" class="w-full"/>
                    </label>
                </div>
                <div>
                    <label>
                        Units owned
                        <Input v-model="form.units_owned" type="number" class="w-full"/>
                    </label>
                </div>
            </div>
            <div class="flex justify-end"  v-if="!this.is_admin">
                <button  class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3 mr-3" @click="destroy(this.form)"> Delete </button>
                <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="update(this.form)"> Update </button>
            </div>
        </div>

    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";
import { mapActions } from 'vuex';
import {isAnyFieldEmpty, emptyError, itemUpdated, itemDeleted} from '../Helpers/Items.js'

export default {
    components: {
        AppLayout,
        Input
    },
    props: {
        item: {
            type: Object,
            required: true,
        }
    },
    data(){
        return {
            form: this.item
        }
    },
    methods:{
        ...mapActions('items',['updateItem', 'deleteItem']),
        update(item){
            if(isAnyFieldEmpty(item))
            {
                emptyError(this.$swal);
            }else {
                this.updateItem(item).then( () => {
                    itemUpdated(this.$swal);
                });
            }
        },
        destroy(item){  
            // console.log(item);
            this.deleteItem(item).then( () => {
                itemDeleted(this.$swal)
            });
        }
    },
}

</script>

<style>

</style>