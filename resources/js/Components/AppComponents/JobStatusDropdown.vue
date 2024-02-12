<template>
    <div class="relative">
        <SecondaryButton class="relative w-36 flex justify-between" @click="toggleDropdown">
            <div>
                <span :class="jobColorClass(selectedJobStatus)" aria-hidden="true"></span>
                <span>{{ selectedJobStatus }}</span>
            </div>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1">
                <ChevronDownIcon class="h-5 w-5 text-gray-400"/>
            </span>
        </SecondaryButton>
        <div v-show="jobStatusDropdownOpen" class="absolute w-44 bg-white mt-1 border rounded-md shadow-lg z-10"
             @click.stop>
            <ul class="max-h-60 overflow-auto">
                <li v-for="(jobStatus, index) in jobStatusList" :key="index" class="p-1">
                    <label class="flex justify-between items-center space-x-3 p-1 font-semibold cursor-pointer"
                           :class="statusLabelClass(jobStatus)"
                           @click="selectJobStatus(jobStatus)">
                        <div>
                            <span :class="jobColorClass(jobStatus)" aria-hidden="true"></span>
                            <span>{{ jobStatus }}</span>
                        </div>
                        <div>
                            <CheckIcon v-if="selectedJobStatus === jobStatus" class="h-5 w-5 text-gray-400"/>
                        </div>
                    </label>
                </li>
                <li class="border-t border-gray-300 p-1">
                    <label class="flex justify-between items-center space-x-3 p-1 font-semibold"
                           :class="statusLabelClass('Archive')"
                           @click="selectJobStatus('Archive')">
                        <div>
                            <span class="inline-block h-2 w-2 flex-shrink-0 rounded-full bg-red-400 mr-2 p-1.5"
                                  aria-hidden="true"></span>
                            <span>Archive</span>
                        </div>
                        <div>
                            <CheckIcon v-if="selectedJobStatus === 'Archive'" class="h-5 w-5 text-gray-400"/>
                        </div>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import {defineEmits, ref} from 'vue';
import { CheckIcon, ChevronDownIcon} from "@heroicons/vue/solid";
import SecondaryButton from "@/Components/SecondaryButton.vue";

let props = defineProps({
    status: String,
})

const emit = defineEmits(['selectStatus']);

const jobStatusDropdownOpen = ref(false);
const selectedJobStatus = ref(props.status);
const jobStatusList = ref([
    'New',
    'Completed',
    'Billed',
    'Sold'
]);

const toggleDropdown = () => {
    jobStatusDropdownOpen.value = !jobStatusDropdownOpen.value;
};

const selectJobStatus = (status) => {
    selectedJobStatus.value = status;
    toggleDropdown();
    emit('selectStatus', status);
};

const jobColorClass = (status) => {
    const baseClass = 'inline-block h-2 w-2 flex-shrink-0 rounded-full mr-2 p-1.5';
    let colorClass = 'bg-gray-400';
    switch (status) {
        case 'New':
            colorClass = 'bg-orange-400';
            break;
        case 'Sold':
            colorClass = 'bg-emerald-500';
            break;
        case 'Completed':
            colorClass = 'bg-gray-400';
            break;
        case 'Billed':
            colorClass = 'bg-blue-500';
            break;
        case 'Archive':
            colorClass = 'bg-red-400';
            break;
    }
    return `${baseClass} ${colorClass}`;
};

const statusLabelClass = (status) => {
    return selectedJobStatus.value === status ? 'bg-blue-600 text-white' : 'text-black';
};
</script>
