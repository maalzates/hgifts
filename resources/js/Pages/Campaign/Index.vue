<template>
  <app-layout :is_admin="this.is_admin">
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Campaigns List
            </h2>
            
        </div>
        <div v-if="!this.is_admin"><span class="font-bold mr-2 bg-blue-500 ">Filters</span>
         <button @click="today()" class="btn mr-2 bg-blue-500"> All</button>
        <!-- <button @click="filterActiveOrSubscribedCampaigns()" class="btn mr-2 bg-blue-500"> All</button> -->
        <button @click="filterActiveCampaigns()" class="btn mr-2 bg-blue-500" > Active </button>
        <button @click="filterSubscribedCampaigns()" class="btn mr-2 bg-blue-500"> Suscribed</button>
        </div>
    </template>
            <!-- Campaign lists ALL-->
        <!-- This example requires Tailwind CSS v2.0+ -->

        <div>
            <h1>Campaigns</h1>
            <ul>
                <li v-for="campaign in all_campaigns" :key="campaign.id">
                    {{ campaign.name}}
                </li>
            </ul>

            <h1>Active Campaignss</h1>
            <ul>
                <li v-for="campaign in active_campaigns" :key="campaign.id">
                    {{campaign.name}}
                    {{ campaign.dispatch_date }}
                </li>
            </ul>
            <h1>Subscribed Campaigns</h1>
            <ul>
                <li v-for="campaign in subscribed_campaigns" :key="campaign.id">
                    {{campaign.name}}
                </li>
            </ul>
            {{current_user}}

        </div>
        
  </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import { mapActions, mapState, mapGetters } from 'vuex';


export default {
    components: {
        AppLayout,
    },
    data(){
    },
    computed: {
        ...mapState("campaigns", ["all_campaigns", "current_user"]),
        ...mapGetters('campaigns', ['active_campaigns', 'subscribed_campaigns'])
    },
    created(){
        this.fetchCampaigns(),
        this.fetchUser()
    },
    methods:{
        ...mapActions('campaigns', ['fetchCampaigns', 'fetchUser']),
    },
}
</script>

<style>
    body{
        overflow-x: hidden;
    }
</style>