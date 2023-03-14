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
            <div class="flex justify-end"  v-if="this.is_admin">
                <button  class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3 mr-3" @click="destroy"> Delete </button>
                <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="update"> Update </button>
            </div>
        </div>

    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";
import JetValidationErrors from "../../Jetstream/ValidationErrors.vue";

export default {
    components: {
        AppLayout,
        Input,
        JetValidationErrors
    },
    props: {
        item: {
            type: Object,
            required: true,
        },
        is_admin: {
            type: Boolean,
        },
    },
    data(){
        return {
            form: this.item,
        }
    },
    methods:{
        update(){
            // this.$inertia.put(this.route('items.update', this.item), this.form);

            // axios.post(route('items.update', this.item), {__method: 'PUT', ...this.form})
            // .then(response => {
            //     console.log(response);
            // })
            // .catch(error => {
            //     // Handle errors
            // });

            
            axios.post(`/items/${this.item.id}`, {
                    ...this.form,
                    _method: 'PUT',    
                })
                .then((response) => {
                    window.location.href = this.route('items.index');
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        destroy(){
            
            // this.$inertia.delete(this.route('items.destroy', this.item), this.form);
            axios.post(`/items/${this.item.id}`, {
                    ...this.form,
                    _method: 'DELETE',    
                })
            .then(response => {
                window.location.href = this.route('items.index');
                console.log(response);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}

</script>

<style>

</style>