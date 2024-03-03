<script setup>
import {ref,onMounted, onUnmounted} from 'vue';
import {DotsVerticalIcon} from "@heroicons/vue/outline";

const emit = defineEmits(['submit-form']);

let props = defineProps({
    eachRecord: Number,
    allowEdit: {
        type: Boolean,
        default: true,
    },
    allowDuplicate: {
        type: Boolean,
        default: true,
    },
    allowDelete: {
        type: Boolean,
        default: true,
    },
})

const dropdownOpen = ref(false);  // boolean flag for dropdown visibility
const EditRecordAction = ref('viewRecord');
const duplicateRecordAction = ref('duplicateRecord');
const deleteRecordAction = ref('deleteRecord');
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value; // toggle dropdown visibility
}

const EditRecord = (eachRecord) => {
    emit('submit-form', eachRecord, EditRecordAction.value);
    dropdownOpen.value = false;
}

const duplicateRecord = (eachRecord) => {
    emit('submit-form', eachRecord, duplicateRecordAction.value);
    dropdownOpen.value = false;
}

const deleteRecord = (eachRecord) => {
    emit('submit-form', eachRecord, deleteRecordAction.value);
    dropdownOpen.value = false;
}

// Handle Click out of component with the use of <div ref="elementRef" class="relative inline-block text-left">
const elementRef = ref(null)
const handleClickOutside = (event) => {
    if (elementRef.value && !elementRef.value.contains(event.target)) {
        dropdownOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    window.removeEventListener('click', handleClickOutside);
});
</script>
<template>
    <div ref="elementRef" class="relative inline-block text-left">
        <!-- Trigger element, which toggles dropdown when clicked -->
        <div v-on:click="toggleDropdown" class="cursor-pointer">
            <DotsVerticalIcon class="lg:ml-2 w-5 h-5 section-button-icon"/>
        </div>

        <!-- Dropdown content -->
        <div v-show="dropdownOpen" class="origin-top-right absolute right-0 mt-2 w-28 rounded-md shadow-lg z-50">
            <div class="rounded-md bg-white shadow-xs">
                <div class="py-1">
                    <a href="#" v-on:click.prevent="EditRecord(eachRecord)" v-if="allowEdit"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">View\Edit</a>
                    <a href="#" v-on:click.prevent="duplicateRecord(eachRecord)" v-if="allowDuplicate"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Duplicate</a>
                    <a href="#" v-on:click.prevent="deleteRecord(eachRecord)" v-if="allowDelete"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-300">Delete</a>
                </div>
            </div>
        </div>
    </div>
</template>
