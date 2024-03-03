<template>
    <Modal :show="show">
        <div class="flex flex-col p-6 space-y-10">
            <p class="text-black text-xl font-medium">{{ message }}</p>
            <div class="flex justify-between md:justify-end space-x-2">
                <SecondaryButton @click="onCancel" type="button"  class="bg-white text-black">
                    {{ cancelLabel }}
                </SecondaryButton>
                <PrimaryButton class="bg-red-500" @click="onConfirm" type="button">
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

const emit = defineEmits(['onConfirm', 'onCancel']);


let props = defineProps({
    show: Boolean,
    message: String,
    confirmLabel: String,
    cancelLabel: String,
    onConfirm: Function,
    onCancel: Function
})

const onCancel = () => {
    emit('onCancel');
}

const onConfirm = () => {
    emit('onConfirm');
}

</script>
