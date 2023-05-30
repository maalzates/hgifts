<template>
  <app-layout :is_admin="this.is_admin">
    <template #header>
        <div class="flex justify-between">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Campaign - {{campaign.name}}</h2> 
            <button @click="generatePDF">Print User Addresses</button>
        </div>
      <!-- {{this.users}} -->
    </template>
            <!-- SHOW VIEW -->
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="border-t border-gray-200">
                <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Campaign Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{campaign.name}}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{campaign.status}}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Dispatch Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{campaign.dispatch_date}}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Delivery Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{campaign.delivery_date}}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Users</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"> <span v-for="(user, index) in users" :key="index" > - {{user.name}} </span></dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b-2">
                    <dt class="text-sm font-medium text-gray-500">Rating</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><StarRating v-model:rating="form.average" :active-on-click="true" read-only rounded-corners="true" :star-size="30" :padding="1" ></StarRating></dd>
                </div>
                                                    
                <!-- COMMENT - RATING BUTTONS -->
                <div class="flex justify-start border-b-2" >
                <CommentsModal>
                    <template #title>
                        <h2> Add a comment to this Campaign</h2>
                    </template>
                    <template #content >
                        <div class="mb-2">
                        <textarea
                            class="w-full h-20 p-2 border rounded focus:outline-none focus:ring-gray-300 focus:ring-1 resize-none	"
                            name="comment"
                            placeholder=""
                            v-model="form.comment.content" ></textarea>
                        </div>
                    </template>
                    <template #footer>
                        <button class="px-3 py-2 text-sm text-blue-100 bg-blue-600 rounded" @click="sendComment">
                        Comment
                        </button>
                    </template>
                </CommentsModal>

                <!-- RATING SECTION -->

                <RatingModal v-if="!this.has_rated">
                    <template #title> Rating</template>
                    <template #content>
                        <StarRating v-model:rating="form.score" :active-on-click="true" clearable ></StarRating>    
                    </template>
                    <template #footer>
                        <button class="px-3 py-2 text-sm text-blue-100 bg-blue-600 rounded" @click="rate">
                        Rate
                        </button>
                    </template>
                </RatingModal>
                </div>

                <!-- COMMENTs SECTION -->
                <!-- Card -->
                <div v-for="comment in this.component_comments" :key="comment.id" class="flex flex-col rounded shadow-sm bg-white overflow-hidden"  >
                <!-- Card Body -->
                <div class="p-5 lg:p-6 grow w-full space-y-4 border-b purple">
                    <!-- Media Object: Comment -->
                    <div class="flex space-x-4">
                    <!-- Avatar -->
                    <img src="https://cdn.tailkit.com/media/placeholders/avatar-mEZ3PoFGs_k-160x160.jpg" alt="User Avatar" class="flex-none inline-block w-8 h-8 sm:w-12 sm:h-12 rounded-full mt-1">

                    <!-- Content -->
                    <div class="grow text-sm flex flex-column align-center">
                        <p class="mb-1 align-self">
                        <a href="javascript:void(0)" class="font-semibold text-blue-600 hover:text-blue-400">{{comment.user.name}}</a>
                        {{comment.content}}
                        </p>
                    </div>
                    <!-- END Content -->
                    </div>
                    <!-- END Media Object: Comment -->
                </div>
                <!-- END Card Body -->
                </div>
                <!-- END Card -->
                </dl>
            </div>
            
        </div>

  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import CommentsModal from "../Components/CommentsModal.vue";
import RatingModal from "../Components/RatingModal.vue";
import StarRating from 'vue-star-rating';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';




export default {
    components: {
        AppLayout,
        CommentsModal,
        StarRating,
        RatingModal,
    },
    props: {
        campaign: {
            type: Object,  
        },
        users: {
            type: Object,
        },
        comments: {
            type: Object
        },
        current_user: {
            type: Object
        },
        average: {
            type: Number
        },
        has_rated: {
            type: Boolean
        },
        is_admin: {
            type: Boolean,
        },
    },
    data(){
        return {
            form: {
                ...this.campaign,
                comment: {  
                    content: '',
                    campaign_id: this.campaign.id,
                    user_id: this.current_user.id,
                },
                score: '',
                average: this.average,
                user: this.current_user.id, // Needed for rating logic
                is_rating: false, // We will use for the Controller to know if a raiting is being sent. 
            },
            component_comments: this.comments,
        }
    },
    methods:{
        rate(){
            this.form.is_rating = true; // This will tell the controller that we're updating the rating instead the campaign itself.
            this.form.score = this.form.score.toString();// We need to convert the score to string, since mysql enum values are 0-indexed. In order to save the actual 5, it needs to be a String.
            
            // this.$inertia.put(this.route('campaigns.update', this.campaign), this.form);
            
            axios.put(`/campaigns/${this.campaign.id}`, {
                ...this.form,
                 _method: 'PUT',    
            })
            .then((response) => {
                console.log(response);
                window.location.reload();
                this.form.is_rating = false;
            })
            .catch(error => {
                console.log(error);
            });
        },
        sendComment() {
            // this.$inertia.post(this.route('comments.store'), this.form.comment);
            axios.post('/comments', this.form.comment)
            .then(response => {
                window.location.reload();
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
                // Handle the error here
            });
        },
        
        generatePDF(){
            const doc = new jsPDF()

            doc.text(`User addresses for campaign: ${this.campaign.name}`, 10, 10)

            const headers = ['Name', 'Address']
            const data = []

            this.users.forEach(user => {
            const row = []
            row.push(user.name)
            row.push(user.address)
            data.push(row)
            })

            doc.autoTable({
            head: [headers],
            body: data
            })

            doc.save('addresses.pdf')
            
        }
    }

}
</script>

<style>

</style>