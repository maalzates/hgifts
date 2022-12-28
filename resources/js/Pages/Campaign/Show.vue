<template>
  <app-layout>
    <template #header>
      <h2 class="flex font-semibold text-xl text-gray-800 leading-tight"> Campaign - {{campaign.name}}</h2>    
      <!-- {{this.users}} -->
    </template>
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <!-- <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Applicant Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
        </div> -->
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
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><StarRating v-model:rating="form.average" :active-on-click="true" read-only	rounded-corners="true" :star-size="30" :padding="1" ></StarRating></dd>
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
                        {{this.form.comment}}
                    </template>
                    <template #footer>
                        <button class="px-3 py-2 text-sm text-blue-100 bg-blue-600 rounded" @click="sendComment">
                        Comment
                        </button>
                    </template>
                </CommentsModal>

                <!-- RATING SECTION -->

                <RatingModal>
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
                <div class="flex flex-col rounded shadow-sm bg-white overflow-hidden">
                <!-- Card Body -->
                <div class="p-5 lg:p-6 grow w-full space-y-4">
                    <!-- Media Object: Comment -->
                    <div class="flex space-x-4">
                    <!-- Avatar -->
                    <img src="https://cdn.tailkit.com/media/placeholders/avatar-mEZ3PoFGs_k-160x160.jpg" alt="User Avatar" class="flex-none inline-block w-8 h-8 sm:w-12 sm:h-12 rounded-full mt-1">

                    <!-- Content -->
                    <div class="grow text-sm">
                        <p class="mb-1">
                        <a href="javascript:void(0)" class="font-semibold text-blue-600 hover:text-blue-400">Lori Grant</a>
                        I just started a new Tailwind CSS based project and I find it very refreshing. Could you suggest any tools to help me out?
                        </p>
                        <p class="space-x-2">
                        <a href="javascript:void(0)" class="text-gray-500 hover:text-gray-400">
                            Like
                        </a>
                        <a href="javascript:void(0)" class="text-gray-500 hover:text-gray-400">
                            Reply
                        </a>
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
        {{current_user}}
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import CommentsModal from "../Components/CommentsModal.vue";
import RatingModal from "../Components/RatingModal.vue";
import StarRating from 'vue-star-rating'




export default {
    components: {
        AppLayout,
        CommentsModal,
        StarRating,
        RatingModal
    },
    props: {
        campaign: {
            type: Object,  
        },
        users: {
            type: Object,
        },
        current_user: {
            type: Object
        }
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
                average: 5,
                user: this.current_user.id,
                is_rating: false,
            }
        }
    },
    methods:{
        rate(){
            this.form.is_rating = true;
            this.$inertia.put(this.route('campaigns.update', this.campaign), this.form);
            this.form.is_rating = false;
        },
        sendComment(){
            this.$inertia.post(this.route('comments.store'), this.form.comment);
        }
    }

}
</script>

<style>

</style>