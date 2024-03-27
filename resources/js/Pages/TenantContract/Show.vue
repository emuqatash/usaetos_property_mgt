<template>
<AuthenticatedLayout :sub-menu="'TENANTCONTRACTS'">
    <form @submit.prevent="submit">
        <div>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <div class="flex justify-between items-center mb-4 lg:mb-14">
                <SecondaryButton class="xl:text-sm font-bold" @click="backToList">
                    <ArrowLeftIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
                    <span class="hidden md:inline-block">Back</span>
                </SecondaryButton>
                <SecondaryButton class="xl:text-sm font-bold" @click="createNewRecord">
                    <FolderAddIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
                    <span class="hidden md:inline-block">New Tenancy Contract</span>
                </SecondaryButton>
            </div>

                <div class="lg:flex gap-2 space-y-4 md:space-y-0">
                    <div class="lg:w-3/12">
                        <Editable type="text"
                                  label="First Name"
                                  :input-value="form.first_name"
                                  @update:value="form.first_name = $event"
                                  :error="form.errors.first_name"
                                  :disabled="true"/>
                    </div>
                    <div class="lg:w-3/12">
                        <Editable
                            type="text"
                            label="Last Name"
                            :input-value="form.last_name"
                            @update:value="form.last_name = $event"
                            :error="form.errors.last_name"
                            :disabled="true"/>
                    </div>
                    <div class="lg:w-2/12">
                        <Editable
                            type="text"
                            label="Phone Number 1"
                            :input-value="form.phone_number_1"
                            @update:value="form.phone_number_1 = $event"
                            :error="form.errors.phone_number_1"
                            :disabled="true"/>
                    </div>
                    <div class="lg:w-4/12">
                        <Editable
                            type="text"
                            label="Email"
                            :input-value="form.email"
                            @update:value="form.email = $event"
                            :error="form.errors.email"
                            :disabled="true"/>
                    </div>
                </div>
            </div>
    </form>

    <template v-if="tenantContracts?.data?.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Contract no
                    </th>
                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">
                        Start Date
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">End Date</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">Property No</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachTenantContract, index) in tenantContracts.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachTenantContract.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachTenantContract.id) }"
                    @click="selectRow(eachTenantContract.id)">
                    <td class="flex-wrap lg:whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ eachTenantContract.contract_no }}
                    </td>
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ eachTenantContract.start_date }}
                    </td>
                    <td class="flex-wrap py-4 text-sm text-gray-500 hidden md:inline-block">
                        {{ eachTenantContract.end_date }}
                    </td>
                    <td class="flex-wrap lg:whitespace-nowrap py-3 text-sm text-gray-500">
                        {{ eachTenantContract.property_no }}
                    </td>
                    <td class="relative whitespace-nowrap py-4 pr-4 text-right text-sm font-medium sm:pr-0">
                        <DotsVertical :eachRecord="eachTenantContract.id" @submit-form="recordAction"
                                      :allowDuplicate="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--------------------pagination--------------------------->
            <Pagination :pagination="tenantContracts"/>
            <!--------------------pagination--------------------------->
            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                @onConfirm="deleteRecordConfirmed(deleteRecordId)"
                @onCancel="closeModel"
                :show="modalActive"
                :message="'Are you sure you want to delete this record ' + deleteRecordId + '?'"
                confirmLabel="Yes, delete it!"
                cancelLabel="Cancel"
            />
            <!--------------------Popup Confirmation Delete--------------------------->
        </div>
    </template>
    <template v-else>
        <EmptyState @page-Create-Active="createNewRecord" :title="'Tenancy Contract'"/>
    </template>
</AuthenticatedLayout>
</template>

<script setup>
import Editable from "@/Components/Editable.vue";
import {useForm, router} from "@inertiajs/vue3";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {FolderAddIcon, ArrowLeftIcon} from '@heroicons/vue/solid';
import DotsVertical from "@/Components/DotsVertical.vue";
import Pagination from "@/Components/Pagination.vue";
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EmptyState from "@/Components/AppComponents/EmptyState.vue";

let props = defineProps({
    tenantContracts: Object,
    tenant: Object,
    properties: Object
})

const selectedRows = ref([])
const isLoading = ref(false);
const recordId = ref(null);
const deleteRecordId = ref(null);
const modalActive = ref(false)

let form = useForm({
    'id': props.tenantContracts ? props.tenantContracts.tenant_id : '',
    //Tenant information
    'first_name': props.tenant ? props.tenant.first_name : '',
    'last_name': props.tenant ? props.tenant.last_name : '',
    'phone_number_1': props.tenant ? props.tenant.phone_number_1 : '',
    'email': props.tenant ? props.tenant.email : '',

    //Tenant contract information
    'contract_no': props.tenantContracts ? props.tenantContracts.contract_no : '',
    'description': props.tenantContracts ? props.tenantContracts.description : '',
    'document_id': props.tenantContracts ? props.tenantContracts.document_id : '',
    'start_date': props.tenantContracts ? props.tenantContracts.start_date : '',
    'end_date': props.tenantContracts ? props.tenantContracts.end_date : '',
    'total_period': props.tenantContracts ? props.tenantContracts.total_period : '',
    'annual_rent': props.tenantContracts ? props.tenantContracts.annual_rent : '',
    'term_of_payment': props.tenantContracts ? props.tenantContracts.term_of_payment : '',
    'security_deposit': props.tenantContracts ? props.tenantContracts.security_deposit : '',
    'bills_paid_by': props.tenantContracts ? props.tenantContracts.bills_paid_by : '',
    'note': props.tenantContracts ? props.tenantContracts.note : '',

    //Tenant contract attachments
    'attachment_file_name': props.tenantContracts ? props.tenantContracts.tenantContract_attachment_files : [],
    'attachment_file': props.tenantContracts ? props.tenantContracts.attachment_file : '',
    'attachmentFiles': props.tenantContracts ? props.tenantContracts.attachmentFiles : '',
})

// handle upload attachment files
const inputFilter = (newFile, oldFile, prevent) => {
    if (newFile && !oldFile) {
        const MAX_FILE_SIZE_MB = 10
        const fileSizeMB = newFile.size / (1024 * 1024);
        if (!/\.(jpeg|jpe|jpg|gif|png|pdf|webp)$/i.test(newFile.name)) {
            alert('File type must be jpeg, jpe, jpg, gif, pdf, png or webp');
            return prevent();
        }
        if (fileSizeMB > MAX_FILE_SIZE_MB) {
            alert('File size should not be more than ' + MAX_FILE_SIZE_MB + ' MB');
            return prevent();
        }
    }
}

let submit = () => {
    form.post(route('tenant-contract.store'), {
        onStart: () => {
            isLoading.value = true
        },
        onError: () => {
            isLoading.value = false
        },
        onSuccess: () => {
            form.clearErrors()
        },
    })
}

const recordAction = (id, action) => {
    recordId.value = id;
    switch (action) {
        case 'viewRecord':
            router.get(route('tenant-contract.edit', id))
            break;
        case 'duplicateRecord':
            router.get(route('tenant-contract.duplicate', id))
            break;
        case 'deleteRecord':
            deleteRecordId.value = id;
            modalActive.value = true;
            break;
    }
}

let selectedRow = ref(null);

function selectRow(id) {
    selectedRow.value = id;
}

const backToList = () => {
    router.get(route('tenant.index'))
}

const createNewRecord = () => {
    router.get(route('tenant-contract.createTenantContract', props.tenant.id))
}
const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.delete(route('tenant-contract.destroy', id))
    modalActive.value = false;
}

const labelClass = ref('block tracking-wide text-gray-700 text-xs font-bold mb-2')
</script>
