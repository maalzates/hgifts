<script setup>
import Modal from './Modal.vue';
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
<div class="flex ">
    <button class="justify-center text-white-500 bg-violet-600 font-bold px-3 py-2 text-white outline-none focus:outline-none mr-1 mb-1 rounded ease-linear transition-all duration-150" @click="toggleModal">Add items for this campaign</button>
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
            <button class="text-blue-500 background-transparent font-bold px-3 py-1 text-base outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" @click="toggleModal">Done</button>
            <slot name="footer" />
        </div>
    </Modal>
</div>
  
</template>
