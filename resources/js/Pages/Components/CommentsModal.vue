<script setup>
import Modal from '../../Jetstream/Modal.vue';
import {ref} from 'vue'

const emit = defineEmits(['close']);

defineProps({
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },

});

const close = () => {
    emit('close');
};

const show = ref(false);

const toggleModal = () => {
    show.value = !show.value;
}


</script>

<template>
<div>
    <button class="text-white bg-purple-800 rounded-md font-bold px-3 py-2 text-base outline-none focus:outline-none mx-1 my-2 ease-linear transition-all duration-150 hover:bg-purple-600 active:bg-transparent active:text-black active:outline-1 active:outline-black" @click="toggleModal">Add a comment</button>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="px-6 py-4">
            <div class="text-lg">
                <slot name="title" />
            </div>

            <div class="mt-4">
                <slot name="content" />
            </div>
        </div>
        
        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
            <!-- <button class="text-blue-500 background-transparent font-bold px-3 py-1 text-xs outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" @click="toggleModal">close</button> -->
            <slot name="footer" />
            <button class="px-3 py-2 text-sm text-blue-600 border border-blue-500 rounded ml-2"  @click="toggleModal">
            Close
            </button>
        </div>
    </Modal>
</div>

</template>
