<template>
<AuthenticatedLayout :sub-menu="'TENANTS'" class="P-2">
    <div class="flex justify-between items-center mb-8">
        <div class="relative rounded-md shadow-sm mr-8">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <SearchIcon class="w-5 h-5 mr-2.5 text-gray-500"/>
            </div>
            <input type="text" name="search" id="search" v-model="search"
                   class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300
               placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                   placeholder="Search...">
        </div>
        <SecondaryButton class="xl:text-sm font-bold" @click="newTenant">
            <FolderAddIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
            <span class="hidden md:inline-block">New Tenant</span>
        </SecondaryButton>
    </div>
    <template v-if="tenant.data.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">Email</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">Tenant Type</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachTenant, index) in tenant.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachTenant.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachTenant.id) }"
                    @click="selectRow(eachTenant.id)">
                    <td class="flex-wrap lg:whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ eachTenant.first_name }}
                        {{ eachTenant.last_name }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden md:inline-block">{{ eachTenant.email }}</td>
                    <td class="flex-wrap px-3 py-4 text-sm text-gray-500 ">{{ eachTenant.phone_number_1 }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-3.5 text-sm text-gray-500 hidden md:inline-block">{{ eachTenant.tenant_type_name }}</td>
                    <td class="relative whitespace-nowrap py-4 pr-4 text-right text-sm font-medium sm:pr-0" >
                        <DotsVertical :eachRecord="eachTenant.id" @submit-form="recordAction" :tenancyContract="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--------------------pagination--------------------------->
            <Pagination :pagination="tenant" />
            <!--------------------pagination--------------------------->

            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                @onConfirm="deleteRecordConfirmed(recordId)"
                @onCancel="closeModel"
                :show="modalActive"
                :message="'Are you sure you want to delete this record ' + recordId + '?'"
                confirmLabel="Yes, delete it!"
                cancelLabel="Cancel"
            />
            <!--------------------Popup Confirmation Delete--------------------------->
        </div>
    </template>
    <template v-else>
        <EmptyTenant/>
    </template>
</AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {SearchIcon} from "@heroicons/vue/outline";
import {FolderAddIcon} from '@heroicons/vue/solid';
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {debounce} from "lodash";
import EmptyTenant from "@/Pages/Tenant/EmptyTenant.vue";
import DotsVertical from "@/Components/DotsVertical.vue";
import Pagination from "@/Components/Pagination.vue";
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";


let props = defineProps({
    tenant: Object,
    filters: Object,
})

const selectedRows = ref([])
const search = ref(props.filters.search)
const modalActive = ref(false)
const recordId = ref(null);

watch(search, debounce(() => {
        router.get('/tenant', {search: search.value},
            {
                preserveState: true,
                replace: true
            })
    }, 500)
)

const newTenant = () => {
    router.get(route('tenant.create'))
}
/// below manage the dropdown menu and actions
const recordAction = (id, action) => {
    recordId.value = id;
    switch(action) {
        case 'viewTenantContract':
            router.get(route('tenant-contract.show', id))
            break;
        case 'viewRecord':
            router.get(route('tenant.edit', id))
            break;
        case 'duplicateRecord':
            router.get(route('tenant.duplicate', id))
            break;
        case 'deleteRecord':
            modalActive.value = true;
            break;
    }
}

let selectedRow = ref(null);  // ref to store the ID of the selected row
function selectRow(id) {
    selectedRow.value = id;
}

const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.delete(route('tenant.destroy', id))
    modalActive.value = false;
}

</script>


