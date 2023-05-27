<template>
  <app-layout  :is_admin="this.is_admin">
    <template #header>
      <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Crear Nuevo Item {{this.is_admin}}</h2>
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
            <button  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" @click="createItem(this.form)"> Crear</button>
        </div>
    </div>
  </app-layout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../../Jetstream/Input.vue";
import { mapActions } from 'vuex';

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
  methods: {
    ...mapActions('items', ['storeItem']), 
    createItem(item){
      if (this.isAnyFieldEmpty(item)) {
        this.emptyError();
      } else {
        this.storeItem(item).then( () => {
          console.log('created');
          this.itemCreated();
        });
      }
    },
    isAnyFieldEmpty(item_form){
      for (let key in item_form) {
        if (item_form[key] === '') {
          return true; // Found an empty property
        }
      }
      return false; // No empty properties found
    },

    emptyError(){
      this.$swal.fire({
          icon: 'error',
          title: 'Empty Field Error',
          text: 'One or more inputs  are empty, fill them all'
      })
    },

    itemCreated(){
      this.$swal.fire({
      icon: 'success',
      title: 'Item Created',
      text: 'The item has been successfully created.',
      });
    }
  },
  computed: {
    
  }
}
</script>

<style>

</style>