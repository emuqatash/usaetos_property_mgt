<template>
    <div class="relative">
        <button
            @click="dropdownOpen = !dropdownOpen" class="flex items-center"
        >
            <span class="pl-2">
                <PlusCircleIcon class="h-10 w-5 text-gray-400 mr-2"/>
            </span>
            {{ buttonLabel }}
            <!-- Add an icon to indicate this is a dropdown -->
        </button>
        <div
            v-show="dropdownOpen"
            class="absolute w-full bg-white mt-1 border rounded-md shadow-lg z-10"
            @click.stop
        >
            <ul class="max-h-60 overflow-auto">
                <li v-for="salesman in salesmen" :key="salesman.id" class="p-1">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input
                            type="checkbox"
                            :value="salesman.id"
                            @change="toggleSelection()"
                            v-model="selectedSalesmen"
                            class="form-checkbox h-5 w-5 text-sm rounded border-gray-300 focus:ring-indigo-600"
                        />
                        <span>{{ salesman.name }}</span>
                    </label>
                </li>
                <li class="p-1 mt-2 text-sm text-black border-t border-gray-300">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input
                            type="checkbox"
                            :checked="isNoAssigneesSelected"
                            @change="toggleSelection('noAssigneeOption')"
                            class="form-checkbox h-5 w-5 text-sm rounded border-gray-300 focus:ring-indigo-600"
                        />
                        <span>{{ noAssigneeOption.name }}</span>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import {computed, defineEmits, ref, watch} from 'vue';
import {PlusCircleIcon} from "@heroicons/vue/solid";

const props = defineProps({
    salesmen: Array,
    buttonLabel: String,
    selected: Array,
});

const emit = defineEmits(['emitSelection']);

const selectedSalesmen = ref([]);
const dropdownOpen = ref(false);

watch(() => props.selected, () => {
    selectedSalesmen.value = props.selected
})

const noAssigneeOption = {id: 'no-assignees', name: 'No Assignees'};

function toggleSelection(type) {
    if (type === 'noAssigneeOption') {
        selectedSalesmen.value = []
    }
    emit('emitSelection', selectedSalesmen.value);
}

const isNoAssigneesSelected = computed(() => selectedSalesmen.value.length === 0);

// Handle clicking outside the dropdown to close it
window.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
        dropdownOpen.value = false;
    }
});

</script>
