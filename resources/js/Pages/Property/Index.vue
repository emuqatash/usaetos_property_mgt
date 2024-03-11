<template>
<AuthenticatedLayout :sub-menu="'PROPERTIES'" class="P-2">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="relative rounded-md shadow-sm mr-2">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <SearchIcon class="w-5 h-5 mr-2.5 text-gray-500"/>
                </div>
                <input type="text" name="search" id="search" v-model="search"
                       class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300
            placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="Search...">
            </div>
            <button class="rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600"
                    @click="$inertia.get(route('property.index'))">
                <RefreshIcon class="w-5 h-5 text-gray-500"/>
            </button>
        </div>

        <SecondaryButton class="xl:text-sm font-bold" @click="newProperty">
            <FolderAddIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
            <span class="hidden md:inline-block">New Property</span>
        </SecondaryButton>
    </div>
    <template v-if="property.data.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">No</th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Owner</th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">City & State</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachProperty, index) in property.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachProperty.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachProperty.id) }"
                    @click="selectRow(eachProperty.id)">
                    <td class="flex-wrap lg:whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ eachProperty.property_no }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ eachProperty.name }}</td>
                    <td class="flex-wrap px-3 py-4 text-sm text-gray-500">{{ eachProperty.owner }}</td>
                    <td class="flex-wrap px-3 py-4 text-sm text-gray-500 hidden md:inline-block">{{ eachProperty.city }} \ {{ eachProperty.state_name }}</td>
                    <td class="relative whitespace-nowrap py-4 pr-3 text-right text-sm font-medium sm:pr-0">
                        <DotsVertical :eachRecord="eachProperty.id" @submit-form="recordAction"
                                      :allowDuplicate="true" :allowPropertyExpenses="true" :allowPropertyMonthlyRent="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--------------------pagination--------------------------->
            <Pagination :pagination="property" />
            <!--------------------pagination--------------------------->
            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                @onConfirm="deleteRecordConfirmed(deleteRecordId)"
                @onCancel="closeModel"
                :show="modalActive"
                :message="'Are you sure you want to delete this Property record along with Expenses and Rent records ?'"
                confirmLabel="Yes, delete it!"
                cancelLabel="Cancel"
            />
            <!--------------------Popup Confirmation Delete--------------------------->
        </div>
    </template>
    <template v-else>
        <EmptyState @page-Create-Active="createNewRecord" :title="'Property'"/>
    </template>
</AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {RefreshIcon, SearchIcon} from "@heroicons/vue/outline";
import {FolderAddIcon} from '@heroicons/vue/solid';
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {debounce} from "lodash";
import DotsVertical from "@/Components/DotsVertical.vue";
import Pagination from "@/Components/Pagination.vue";
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";
import EmptyState from "@/Components/AppComponents/EmptyState.vue";

let props = defineProps({
    property: Object,
    filters: Object,
})

const selectedRows = ref([])
const search = ref(props.filters.search)
const modalActive = ref(false)
const deleteRecordId = ref(null);

watch(search, debounce(() => {
        router.get('/property', {search: search.value},
            {
                preserveState: true,
                replace: true
            })
    }, 500)
)

const newProperty = () => {
    router.get(route('property.create'))
}
/// below manage the dropdown menu and actions
const recordAction = (id, action) => {
    switch(action) {
        case 'viewPropertyMonthlyRent':
            router.get(route('property-rent.show', id))
            break;
        case 'viewPropertyExpenses':
            router.get(route('property-expense.show', id))
            break;
        case 'viewRecord':
            router.get(route('property.edit', id))
            break;
        case 'duplicateRecord':
            router.get(route('property.duplicate', id))
            break;
        case 'deleteRecord':
            deleteRecordId.value = id;
            modalActive.value = true;
            break;
    }
}

const createNewRecord = () => {
    router.get(route('property.create', props.id ))
}

let selectedRow = ref(null);  // ref to store the ID of the selected row
function selectRow(id) {
    selectedRow.value = id;
}

const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.delete(route('property.destroy', id))
    modalActive.value = false;
}
</script>


