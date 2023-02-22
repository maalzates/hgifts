<template>
    <app-layout>
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
            <div class="flex justify-end">
                <button  v-if="can('items.destroy')" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3 mr-3" @click="destroy"> Delete </button>
                <button  v-if="can('items.edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="update"> Update </button>

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
    },
    data(){
        return {
            form: this.item,
        }
    },
    methods:{
        update(){
            this.$inertia.put(this.route('items.update', this.item), this.form);
        },
        destroy(){
            this.$inertia.delete(this.route('items.destroy', this.item), this.form);
        }
    },

}
</script>

<style>

</style>