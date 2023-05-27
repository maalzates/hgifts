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
import {isAnyFieldEmpty, emptyError, itemCreated} from '../Helpers/Items.js'

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
      if (isAnyFieldEmpty(item, this.$swal)) {
        emptyError(this.$swal);
      } else {
        this.storeItem(item).then( () => {
          console.log('created');
          itemCreated(this.$swal);
        });
      }
    }
  },
  computed: {
    
  }
}
</script>

<style>

</style>