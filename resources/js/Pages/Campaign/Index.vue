<template>
  <app-layout :is_admin="this.is_admin">
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Campaigns
            </h2>
            
        </div>
        <div v-if="this.is_admin"><span class="font-bold mr-2 ">Filters</span>
         <!-- <button @click="today()" class="btn mr-2 bg-blue-500"> All</button> -->
        <button @click="filterActiveOrSubscribedCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': active_or_subscribed_filter }" > All</button>
        <button @click="filterActiveCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': active_filter }"> Active </button>
        <button @click="filterSubscribedCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': subscribed_filter }"> Subscribed</button>
        </div>
    </template>
            <!-- Campaign lists ALL-->
        <!-- This example requires Tailwind CSS v2.0+ -->

        <div v-if="active_filter" >
            <!-- ACTIVE CAMPAIGNS  -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr >
                            <th scope="col" class="px-6 py-3">
                                NAME
                            </th>
                            <th scope="col" class="px-6 py-3">
                                STATUS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                CONTENT
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DISPATCH DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DELIVERY DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                USERS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                SUBSCRIPTION
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campaign in active_campaigns.data" :key="campaign.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{campaign.name}}
                            </th>
                            <td class="px-6 py-4">
                                {{campaign.status}}
                            </td>
                            <td class="px-6 py-4">
                                ITEMS
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.dispatch_date}}
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.delivery_date}}
                            </td>
                            <td class="px-6 py-4">
                                USERS
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">SUBS BUTTON</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center align-center">
                <TailwindPagination :data="active_campaigns" @pagination-change-page="fetchCampaigns"/>
            </div>
        </div>
        <div v-if="subscribed_filter" >
            <!-- SUBSCRIBED CAMPAIGNS -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr >
                            <th scope="col" class="px-6 py-3">
                                NAME
                            </th>
                            <th scope="col" class="px-6 py-3">
                                STATUS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                CONTENT
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DISPATCH DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DELIVERY DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                USERS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                SUBSCRIPTION
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campaign in subscribed_campaigns.data" :key="campaign.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{campaign.name}}
                            </th>
                            <td class="px-6 py-4">
                                {{campaign.status}}
                            </td>
                            <td class="px-6 py-4">
                                ITEMS
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.dispatch_date}}
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.delivery_date}}
                            </td>
                            <td class="px-6 py-4">
                                USERS
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">SUBS BUTTON</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center align-center">
                <TailwindPagination :data="subscribed_campaigns" @pagination-change-page="fetchCampaigns"/>
            </div>
        </div>
        <div v-if="active_or_subscribed_filter" >
           <!-- ACTIVE OR SUBSCRIBED CAMPAIGNS -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr >
                            <th scope="col" class="px-6 py-3">
                                NAME
                            </th>
                            <th scope="col" class="px-6 py-3">
                                STATUS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                CONTENT
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DISPATCH DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DELIVERY DAY
                            </th>
                            <th scope="col" class="px-6 py-3">
                                USERS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                SUBSCRIPTION
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campaign in active_or_subscribed_campaigns.data" :key="campaign.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{campaign.name}}
                            </th>
                            <td class="px-6 py-4">
                                {{campaign.status}}
                            </td>
                            <td class="px-6 py-4">
                                ITEMS
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.dispatch_date}}
                            </td>
                            <td class="px-6 py-4">
                                {{campaign.delivery_date}}
                            </td>
                            <td class="px-6 py-4">
                                USERS
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">SUBS BUTTON</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center align-center">
                <TailwindPagination :data="active_or_subscribed_campaigns" @pagination-change-page="fetchCampaigns"/>
            </div>
        </div>

  </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import { mapActions, mapState} from 'vuex';
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    components: {
        AppLayout,
        TailwindPagination
    },
    data(){
        return {
            active_filter: null,
            subscribed_filter: null,
            active_or_subscribed_filter: true,
        }
    },
    computed: {
        ...mapState("campaigns", ["all_campaigns",'active_campaigns', 'subscribed_campaigns', 'active_or_subscribed_campaigns', 'is_admin', "current_user"]),
        // ...mapGetters('campaigns', ['active_campaigns', 'subscribed_campaigns', 'subscribed_or_active_campaigns'])
    },
    created(){
        this.fetchUser(),      
        this.fetchCampaigns().then( () => {
            if(JSON.parse(window.localStorage.getItem("active_campaigns"))){
                this.active_filter = true;
                this.subscribed_filter = false;
                this.active_or_subscribed_filter = false;
            }
            else if( JSON.parse(localStorage.getItem("subscribed_campaigns"))){
                this.subscribed_filter = true;
                this.active_filter = false;
                this.active_or_subscribed_filter = false;
            }
            else {
                this.active_or_subscribed_filter = true;
                this.active_filter = false;
                this.subscribed_filter = false;
            }
        })
    },
    methods:{
        ...mapActions('campaigns', ['fetchCampaigns', 'fetchUser']),
        filterActiveCampaigns(){
            localStorage.removeItem("subscribed_campaigns");
            localStorage.setItem("active_campaigns", "true");
            this.active_filter = true;
            this.subscribed_filter = false;
            this.active_or_subscribed_filter = false;
        },
        filterSubscribedCampaigns(){
            localStorage.removeItem("active_campaigns");
            localStorage.setItem("subscribed_campaigns", "true");
            this.subscribed_filter = true;
            this.active_filter = false;
            this.active_or_subscribed_filter = false;
        },
        filterActiveOrSubscribedCampaigns(){
            localStorage.removeItem("active_campaigns");
            localStorage.removeItem("subscribed_campaigns");
            this.active_or_subscribed_filter = true;
            this.active_filter = false;
            this.subscribed_filter = false;
        },
    },
}
</script>

<style>
    body{
        overflow-x: hidden;
    }
</style>