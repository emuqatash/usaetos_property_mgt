<template>
    <transition name="modal-animation">
        <div v-show="modalActive" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            <transition name="modal-animation-inner" class="fixed inset-0 z-30 w-screen overflow-y-auto">
                <div v-show="modalActive"
                     class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all
                         sm:my-8 w-full sm:max-w-5xl">
                        <!-- Modal Content -->
                        <slot/>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script setup>

const props = (defineProps({
    modalActive: {
        type: Boolean,
        default: false
    },
    formMode: {
        type: String,
        default: ''
    }
}))

const emit = defineEmits(['close'])

const close = () => {
    emit('close')
}
</script>
<style>
.modal-animation-enter-active,
.modal-animation-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-enter-from,
.modal-animation-leave-to {
    opacity: 0;
}

.modal-animation-inner-enter-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}

.modal-animation-inner-leave-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-inner-enter-from {
    opacity: 0;
    transform: scale(0.8);
}

.modal-animation-inner-leave-to {
    transform: scale(0.8);
}
</style>
