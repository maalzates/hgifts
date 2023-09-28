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
    <button
        type="button"
        class="h-10 px-5 m-2 text-purple-100 transition-colors duration-150 bg-purple-600 rounded-lg focus:shadow-outline hover:bg-purple-700" @click="toggleModal">
        Box Content
    </button>
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
            <button class="focus:outline-none text-white bg-red-700 hover:bg-red-500 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-900" @click="toggleModal">Close</button>
            <slot name="footer" />
        </div>
    </Modal>
</div>

</template>