<template>
  <app-layout :is_admin="this.is_admin">
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Campaigns 
            </h2>
        </div>
        <div v-if="!this.is_admin" class="mt-2" ><span class="font-bold mr-2 ">Filters</span>
         <!-- <button @click="today()" class="btn mr-2 bg-blue-500"> All</button> -->
        <button @click="filterActiveOrSubscribedCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': active_or_subscribed_filter }" > All</button>
        <button @click="filterActiveCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': active_filter }"> Active </button>
        <button @click="filterSubscribedCampaigns()" class="text-white bg-purple-700 hover:bg-purple-800  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" :class="{ 'ring-4 ring-purple-300': subscribed_filter }"> Subscribed</button>
        </div>
    </template>
            <!-- Campaign lists ALL-->
        <!-- This example requires Tailwind CSS v2.0+ -->

     <!-- ADMIN VIEW ---------------------------------------------------------- -->
    <div v-if="this.is_admin" >
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
                        <th scope="col" class="px-6 py-3">
                            EDIT / SHOW
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="campaign in all_campaigns.data" :key="campaign.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{campaign.name}}
                        </th>
                        <td class="px-6 py-4">
                            {{campaign.status}}
                        </td>
                        <td class="px-6 py-4">
                            <!-- ITEMS -->
                            <DialogModal >
                                <template #title>
                                    <h1> Items in this box </h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="item in campaign.items" :key="item.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.name}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.pivot.count}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>
                            </DialogModal>
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.dispatch_date}}
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.delivery_date}}
                        </td>
                        <td class="px-6 py-4">
                            <UsersModal >
                                <template #title>
                                    <h1> Users in this Campaign</h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>                                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="user in campaign.users" :key="user.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{user.name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>
                            </UsersModal>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <button @click="handleSubscription(campaign)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                            <button @click="handleSubscription(campaign)" v-else >Suscribe</button>
                        </td>
                        <td  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900 mr-5 ml-1.5">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                            <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-chevron-right"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-center">
            <TailwindPagination :data="active_campaigns" @pagination-change-page="fetchCampaigns"/>
        </div>
    </div>


    <!-- NORMAL USER VIEW ------------------------------------------ -->
    <div v-else-if="active_filter" >
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
                        <th scope="col" class="px-6 py-3">
                            EDIT / SHOW
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
                            <!-- ITEMS -->
                            <DialogModal v-if="isBoxViewable(campaign.delivery_date)">
                                <template #title>
                                    <h1> Items in this box </h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="item in campaign.items" :key="item.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.name}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.pivot.count}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>

                            </DialogModal>
                            <span v-else class="h-10 px-2.5 m-2"> 
                                Secret Content
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.dispatch_date}}
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.delivery_date}}
                        </td>
                        <td class="px-6 py-4">
                            <UsersModal >
                                <template #title>
                                    <h1> Users in this Campaign</h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>                                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="user in campaign.users" :key="user.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{user.name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>
                            </UsersModal>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <button @click="handleSubscription(campaign)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                            <button @click="handleSubscription(campaign)" v-else >Suscribe</button>
                        </td>
                        <td  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900 mr-5 ml-1.5">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                            <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-chevron-right"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-center">
            <TailwindPagination :data="active_campaigns" @pagination-change-page="fetchCampaigns"/>
        </div>
    </div>


    <div v-else-if="subscribed_filter" >
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
                        <th scope="col" class="px-6 py-3">
                            EDIT / SHOW
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
                            <!-- <DialogModal v-if="isBoxViewable(campaign.delivery_date)"> -->
                            <DialogModal v-if="isBoxViewable(campaign.delivery_date)">
                                <template #title>
                                    <h1> Items in this box </h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="item in campaign.items" :key="item.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.name}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.pivot.count}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>

                            </DialogModal>
                            <span v-else class="h-10 px-2.5 m-2"> 
                                Secret Content
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.dispatch_date}}
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.delivery_date}}
                        </td>
                        <td class="px-6 py-4">
                            <UsersModal >
                                <template #title>
                                    <h1> Users in this Campaign</h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>                                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="user in campaign.users" :key="user.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{user.name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>
                            </UsersModal>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <button @click="handleSubscription(campaign)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                            <button @click="handleSubscription(campaign)" v-else >Suscribe</button>
                        </td>
                        <td  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900 mr-5 ml-1.5">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                            <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-chevron-right"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center align-center">
            <TailwindPagination :data="subscribed_campaigns" @pagination-change-page="fetchCampaigns"/>
        </div>
    </div>


    <div v-else-if="active_or_subscribed_filter" >
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
                        <th scope="col" class="px-6 py-3">
                            Edit / Show
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
                            <DialogModal v-if="isBoxViewable(campaign.delivery_date)">
                                <template #title>
                                    <h1> Items in this box </h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="item in campaign.items" :key="item.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.name}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{item.pivot.count}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>

                            </DialogModal>
                            <span v-else class="h-10 px-2.5 m-2"> 
                                Secret Content
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.dispatch_date}}
                        </td>
                        <td class="px-6 py-4">
                            {{campaign.delivery_date}}
                        </td>
                        <td class="px-6 py-4">
                            <UsersModal >
                                <template #title>
                                    <h1> Users in this Campaign</h1>
                                </template>
                                <template #content >
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>                                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="user in campaign.users" :key="user.id">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{user.name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </template>
                                <template #footer>
                                </template>
                            </UsersModal>
                        </td>
                        <!-- SUSCRIBE/UNSUSCRIBE BUTTON -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <button @click="handleSubscription(campaign)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                            <button @click="handleSubscription(campaign)" v-else >Suscribe</button>
                        </td>
                        <td  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 underline">
                            <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900 mr-5 ml-1.5">
                                <i class="fas fa-regular fa-pen-to-square"></i>
                            </Link>
                            <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-chevron-right"></i>
                            </Link>
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
import DialogModal from '../Components/DialogModal';
import UsersModal from '../Components/UsersModal'
import moment from 'moment';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        AppLayout,
        TailwindPagination,
        DialogModal,
        UsersModal,
        Link
    },
    data(){
        return {
            active_filter: null,
            subscribed_filter: null,
            active_or_subscribed_filter: true,
            form: {}
        }
    },
    computed: {
        ...mapState("campaigns", ["all_campaigns",'active_campaigns', 'subscribed_campaigns', 'active_or_subscribed_campaigns', 'is_admin',"current_user", "variable"])
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
        ...mapActions('campaigns', ['fetchCampaigns', 'fetchUser', 'subscribeAction', 'unsubscribeAction', 'changeVariable']),
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
        isBoxViewable( delivery_date) {
            // Checking if the Box content is viewable based on delivery_date
            let now = moment().format();
            if ( delivery_date > now) {
                return false;
            } else {
                return true;
            }
        },
        isSubscribed(campaign){
            let uids = campaign.users.map((user) => user.id); // get array of user ids in this campaign
            let result = uids.includes(this.current_user.id); // Check if current authenticated user is present in this array. 
            return result;
        },
        handleSubscription(campaign) {

            let is_suscribed = this.isSubscribed(campaign);
            let items = campaign.items.map( item => item.pivot); // We extract the items pivot table information, so that we can get the item_id instead "id", since we need this to our controller logical
            this.form = {...campaign}; // Defines variable form in data(), as a copy of the current campaign content
            this.form.items = items; // We define the form.items as the pivot information that we got at the begining. We need this to our controller logical
            let uids = campaign.users.map((user) => user.id); // Return an array with all current user ids attached to this campaign

            if(is_suscribed){ 

                // UNSUSCRIPTION LOGICAL
                let users = uids.filter( (uid) => uid != this.current_user.id); // Creates a new array, removing the current user id, from the users in this campaign
                this.form.users = users; // Attach the uids of the filtered users to the form data.
                
                // this.$inertia.put(this.route('campaigns.update', campaign), this.form);
                this.unsubscribeAction(this.form).then( () => {
                    this.fetchCampaigns();
                });

            } else { 
                // SUSCRIPTION LOGICAL
                uids.push(this.current_user.id); // Attach the curent user id, to the uids array

                this.form.users = uids; // Attach the uids of the filtered users to the form data.
                // this.$inertia.put(this.route('campaigns.update', campaign), this.form);
                this.subscribeAction(this.form).then( () => {
                    this.fetchCampaigns();
                });

            }
        }
    },
}
</script>

<style>
    body{
        overflow-x: hidden;
    }
</style>