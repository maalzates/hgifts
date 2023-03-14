<template>
  <app-layout :is_admin="this.is_admin">
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Campaigns List
            </h2>
            
            <div class="flex flex-col">
                <Link  :href="route('campaigns.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" v-if="this.is_admin"> Create New</Link>
            </div>
        </div>
        <div v-if="!this.is_admin"><span class="font-bold mr-2 bg-blue-500 ">Filters</span>
        <button @click="filterActiveOrSubscribedCampaigns()" class="btn mr-2 bg-blue-500"> All</button>
        <button @click="filterActiveCampaigns()" class="btn mr-2 bg-blue-500" > Active </button>
        <button @click="filterSubscribedCampaigns()" class="btn mr-2 bg-blue-500"> Suscribed</button>
        </div>
    </template>
            <!-- Campaign lists ALL-->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                    <!-- ADMIN VIEW -->
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" v-if="this.is_admin">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dispatch Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suscription</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Iterating through campaign records rendered as a table -->
                                <tr v-for="campaign in this.campaigns.data" :key="campaign.id" >

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.name}}
                                        <!-- <button @click="isCampaignViewable(campaign.delivery_date, campaign.users)" > button</button> -->
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.status}}
                                    </td>

                                    <!-- ITEMS IN THIS CAMPAIGN  -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <!-- <DialogModal v-if="isBoxViewable(campaign.delivery_date)"> -->
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
<!-- 
                                        <td v-else>
                                            Secret Content
                                        </td> -->

                                        <!-- USO de lista HTML para mostrar los items de cada campaña -->
                                        <!-- <ol v-for="item in campaign.items" :key="item.id" >
                                            <li><p>{{item.name}}</p></li>
                                        </ol> -->
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.dispatch_date}}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.delivery_date}}
                                    </td>
                                    <!-- SUSCRIBED USERS MODAL -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button @click="handleSubscription(campaign)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                                        <button @click="handleSubscription(campaign)" v-else >Subscribe</button>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-between">
                                        <!-- EDIT BUTTON -->
                                        <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-regular fa-pen-to-square"></i>
                                        </Link>
                                        <!-- SHOW BUTTON -->
                                        <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-chevron-right"></i>
                                        </Link>
                                    </td>

                                </tr>

                                <!-- More people... -->
                            </tbody>

                            
                        </table>
                        <Pagination :pagination="campaigns" />
                    </div>

                    <!-- NORMAL USER VIEW -->
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" v-else>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dispatch Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Day</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suscription</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 a" v-for="campaign in campaigns.data" :key="campaign.id">
                                <!-- Iterating through campaign records rendered as a table -->
                                <tr >

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.name}}
                                        <!-- <button @click=" isUserPresent(campaign.users)" > isUserPresent </button>
                                        <button  @click=" isCampaignActive(campaign.delivery_date)" > isCampaignActive</button> -->
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.status}}
                                    </td>

                                    <!-- ITEMS IN THIS CAMPAIGN  -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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

                                        <td v-else>
                                            Secret Content
                                        </td>

                                        <!-- USO de lista HTML para mostrar los items de cada campaña -->
                                        <!-- <ol v-for="item in campaign.items" :key="item.id" >
                                            <li><p>{{item.name}}</p></li>
                                        </ol> -->
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.dispatch_date}}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{campaign.delivery_date}}
                                    </td>
                                    <!-- SUSCRIBED USERS MODAL -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button @click="handleSubscription(campaign, true)" v-if="isSubscribed(campaign)"> Unsuscribe</button>
                                        <button @click="handleSubscription(campaign, false)" v-else >Suscribe</button>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-between">
                                        <!-- EDIT BUTTON -->
                                        <Link :href="route('campaigns.edit', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-regular fa-pen-to-square"></i>
                                        </Link>
                                        <!-- SHOW BUTTON -->
                                        <Link :href="route('campaigns.show', campaign)" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-chevron-right"></i>
                                        </Link>
                                    </td>

                                </tr>

                                <!-- More people... -->
                            </tbody>

                            
                        </table>
                        <Pagination :pagination="campaigns" />
                    </div>

                </div>
            </div>
        </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import DialogModal from '@/Jetstream/DialogModal.vue';
import UsersModal from '../Components/UsersModal.vue';
import Pagination from "../Components/Pagination.vue";
import moment from 'moment';


export default {
    components: {
        AppLayout,
        Link,
        DialogModal,
        UsersModal,
        Pagination,

    },
    props: {
        all_campaigns: {
            type: Object
        },
        current_user: {
            type: Object
        },
        active_campaigns: {
            type: Object
        },
        subscribed_campaigns: {
            type: Object
        },
        active_or_suscribed: {
            type: Object
        },
        is_admin: {
            type: Boolean,
        },
    },
    data(){
        return {
            campaigns: {},
        }
    },
    methods:{
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

                axios.post(`/campaigns/${campaign.id}`, {
                    ...this.form,
                    _method: 'PUT',    
                })
                .then((response) => {
                    window.location.reload();
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });


            } else { 
                // SUSCRIPTION LOGICAL
                uids.push(this.current_user.id); // Attach the curent user id, to the uids array

                this.form.users = uids; // Attach the uids of the filtered users to the form data.
                // this.$inertia.put(this.route('campaigns.update', campaign), this.form);

                axios.post(`/campaigns/${campaign.id}`, {
                    ...this.form,
                    _method: 'PUT',    
                })
                .then((response) => {
                    window.location.reload();
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                
            }
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
        filterActiveCampaigns(){
            localStorage.removeItem("subscribed_campaigns");
            localStorage.setItem("active_campaigns", "true");
            this.campaigns = {...this.active_campaigns};
        },
        filterSubscribedCampaigns(){
            localStorage.removeItem("active_campaigns");
            localStorage.setItem("subscribed_campaigns", "true");
            this.campaigns = {...this.subscribed_campaigns};
        },
        filterActiveOrSubscribedCampaigns(){
            localStorage.removeItem("active_campaigns");
            localStorage.removeItem("subscribed_campaigns");
            this.campaigns = {...this.active_or_suscribed};
        },

    },
    created(){
        if (this.is_admin){
            this.campaigns = {...this.all_campaigns}
        } 
        else if(!this.is_admin) {

            if(JSON.parse(window.localStorage.getItem("active_campaigns"))){
                this.campaigns = {...this.active_campaigns}
            }
            else if( JSON.parse(localStorage.getItem("subscribed_campaigns"))){
                this.campaigns = {...this.subscribed_campaigns}
            }
            else {
                 this.campaigns = {...this.active_or_suscribed}
            }
        }
    }
}
</script>

<style>
    body{
        overflow-x: hidden;
    }
</style>