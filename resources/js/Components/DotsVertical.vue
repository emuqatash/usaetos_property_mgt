<script setup>
import {ref,onMounted, onUnmounted, defineEmits} from 'vue';
import {DotsVerticalIcon} from "@heroicons/vue/outline";

const emit = defineEmits(['submit-form']);

let props = defineProps({
    eachRecord: Number,
    allowEdit: {
        type: Boolean,
        default: true,
    },
    allowPropertyExpenses: {
        type: Boolean,
        default: false,
    },
    allowPropertyMonthlyRent: {
        type: Boolean,
        default: false,
    },
    allowDuplicate: {
        type: Boolean,
        default: false,
    },
    tenancyContract: {
        type: Boolean,
        default: false,
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
const tenantContractAction = ref('viewTenantContract');
const propertyExpensesAction = ref('viewPropertyExpenses');
const propertyMonthlyRentAction = ref('viewPropertyMonthlyRent');


const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value; // toggle dropdown visibility
}

const tenantContract = (eachRecord) => {
    emit('submit-form', eachRecord, tenantContractAction.value);
    dropdownOpen.value = false;
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

const propertyExpenses = (eachRecord) => {
    emit('submit-form', eachRecord, propertyExpensesAction.value);
    dropdownOpen.value = false;
}

const propertyMonthlyRent = (eachRecord) => {
    emit('submit-form', eachRecord, propertyMonthlyRentAction.value);
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
        <div v-show="dropdownOpen" class="origin-top-right absolute right-0 mt-2 min-w-36 rounded-md shadow-lg z-50">
            <div class="rounded-md bg-white shadow-xs">
                <div class="py-1">
                    <a href="#" v-on:click.prevent="tenantContract(eachRecord)" v-if="tenancyContract"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Tenancy Contract</a>

                    <a href="#" v-on:click.prevent="propertyMonthlyRent(eachRecord)" v-if="allowPropertyMonthlyRent"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Add Rent Payment</a>

                    <a href="#" v-on:click.prevent="propertyExpenses(eachRecord)" v-if="allowPropertyExpenses"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Add Expenses</a>

                    <a href="#" v-on:click.prevent="EditRecord(eachRecord)" v-if="allowEdit"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">View\Edit</a>

                    <a href="#" v-on:click.prevent="duplicateRecord(eachRecord)" v-if="allowDuplicate"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Duplicate</a>
<!--                    v-if="allowDelete && userHasRole('Admin', 'Superuser')"-->
                    <a href="#" v-on:click.prevent="deleteRecord(eachRecord)" v-if="allowDelete"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-300">Delete</a>
                </div>
            </div>
        </div>
    </div>
</template>
