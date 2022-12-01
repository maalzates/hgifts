<template>
  <app-layout>
    <template #header>
      <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Crear Nuevo Item</h2>
    </template>
    <!-- Create form -->
    <div class="bg-white px-6 py-8 rounded-lg shadow">
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
            <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="createItem"> Crear</button>
        </div>
    </div>
  </app-layout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";

export default {
  components: {
    AppLayout,
    Input
  },
  data(){
    return{
      form: {
        name: '',
        unit_price: '',
        units_owned: '',
      }
    }
  },
  methods:{
    createItem(){
      this.$inertia.post(route('items.store', this.form))
    }
  }
}
</script>

<style>

</style>