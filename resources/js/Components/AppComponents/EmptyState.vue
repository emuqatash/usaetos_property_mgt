<template>
    <div class="text-center min-h-[400px] flex flex-col items-center justify-center border-2 rounded-lg border-dashed border-gray-300">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">No {{title}}</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a {{title}}.</p>
        <div class="mt-6">
            <AppButton @click="newJob">
                <PlusIcon class="w-6 section-button-icon mr-2" />
                New {{title}}
            </AppButton>
        </div>
    </div>
</template>
<script setup>
import AppButton from "@/Components/AppButton.vue";
import {PlusIcon} from "@heroicons/vue/outline";
import {defineEmits} from "vue";

let props = defineProps({
    title: String,
})

const emit = defineEmits(['page-Create-Active']);

const newJob = () => {
    emit('page-Create-Active' );
}
</script>
