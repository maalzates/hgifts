<template>
  <div>{{this.is_admin}}</div>

  <button @click="filterSubscribedCampaigns">
    Subscribed
  </button>

  <button @click="filterActiveCampaigns">
    Active
  </button>
</template>

<script>
export default {

    props: {
        all_campaigns: {
            type: Object
        },
        is_admin: {
            type: Boolean,
        },
        active_campaigns: {
            type: Object
        },
        subscribed_campaigns: {
            type: Object
        },
        active_or_suscribed: {
            type: Object
        }
    },
    data() {
        return {
            campaigns: {},
            filter: ''
        }
    },
    methods:{
        filterActiveCampaigns(){
            localStorage.removeItem("subscribed_campaigns");
            localStorage.setItem("active_campaigns", "true");
        },
        filterSubscribedCampaigns(){
            localStorage.removeItem("active_campaigns");
            localStorage.setItem("subscribed_campaigns", "true");
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

</style>