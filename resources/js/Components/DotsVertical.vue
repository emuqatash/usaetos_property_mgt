<script setup>
import { ref } from 'vue';
import {DotsVerticalIcon} from "@heroicons/vue/outline";

const emit = defineEmits(['submit-form']);

let props = defineProps({
    eachRecord: Number,
})

const dropdownOpen = ref(false);  // boolean flag for dropdown visibility
const showRecordAction =  ref('viewRecord');
const deleteRecordAction =  ref('deleteRecord');
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value; // toggle dropdown visibility
}

const showRecord = (eachRecord) => {
    emit('submit-form', eachRecord, showRecordAction.value);
    dropdownOpen.value = false;
}

const deleteRecord = (eachRecord) => {
    emit('submit-form', eachRecord, deleteRecordAction.value);
    dropdownOpen.value = false;
}

</script>

<template>
    <div class="relative inline-block text-left">
        <!-- Trigger element, which toggles dropdown when clicked -->
        <div v-on:click="toggleDropdown" class="cursor-pointer">
            <DotsVerticalIcon class="lg:ml-2 w-5 h-5 section-button-icon"/>
        </div>

        <!-- Dropdown content -->
        <div v-show="dropdownOpen" class="origin-top-right absolute right-0 mt-2 w-28 rounded-md shadow-lg z-50">
            <div class="rounded-md bg-white shadow-xs">
                <div class="py-1">
                    <a href="#" v-on:click.prevent="showRecord(eachRecord)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">View</a>
                    <a href="#" v-on:click.prevent="deleteRecord(eachRecord)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-300">Delete</a>
                </div>
            </div>
        </div>
    </div>
</template>
