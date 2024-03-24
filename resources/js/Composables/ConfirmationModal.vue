<template>
    <Modal :show="show">
        <div class="flex flex-col p-6 space-y-10">
            <div class="flex space-x-2">
                <InformationCircleIcon class="h-10 w-10 text-red-600"/>
                <p class="text-black text-xl font-medium">{{ message }}</p>
            </div>
            <div class="flex justify-between md:justify-end space-x-2">
                <SecondaryButton v-if="showCancelButton" @click="onCancel" type="button"  class="bg-white text-black">
                    {{ cancelLabel }}
                </SecondaryButton>
                <PrimaryButton v-if="showConfirmButton" class="bg-red-500" @click="onConfirm" type="button">
                    {{ confirmLabel }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {InformationCircleIcon, PhotographIcon} from '@heroicons/vue/solid';

const emit = defineEmits(['onConfirm', 'onCancel']);


let props = defineProps({
    show: Boolean,
    message: String,
    confirmLabel: String,
    cancelLabel: String,
    onConfirm: Function,
    onCancel: Function,
    showConfirmButton: { type: Boolean, default: true },
    showCancelButton: { type: Boolean, default: true }
})

const onCancel = () => {
    emit('onCancel');
}

const onConfirm = () => {
    emit('onConfirm');
}

</script>
