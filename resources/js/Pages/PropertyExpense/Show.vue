<template>
<AuthenticatedLayout :sub-menu="'PROPERTYEXPENSES'" class="P-2">
<div class="space-y-8 p-4">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="flex justify-between items-center mb-8">
                <SecondaryButton class="xl:text-sm font-bold" @click="backToList">
                    <ArrowLeftIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
                    <span class="hidden md:inline-block">Back</span>
                </SecondaryButton>
                <SecondaryButton class="xl:text-sm font-bold" @click="createNewRecord">
                    <FolderAddIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
                    <span class="hidden md:inline-block">Add Property Expenses</span>
                </SecondaryButton>
            </div>

            <div class="p-6  relative border-b border-gray-100 ">
                <div class="lg:flex gap-2 space-y-4 md:space-y-0">
                    <div class="lg:w-2/12">
                        <Editable type="text"
                                  label="Property No"
                                  :input-value="form.property_no"
                                  @update:value="form.property_no = $event"
                                  :error="form.errors.property_no"
                                  :disabled="true"/>
                    </div>
                    <div class="lg:w-7/12">
                        <Editable
                            type="text"
                            label="Address"
                            :input-value="form.address"
                            @update:value="form.address = $event"
                            :error="form.errors.address"
                            :disabled="true"/>
                    </div>
                    <div class="lg:w-3/12">
                        <Editable
                            type="text"
                            label="City"
                            :input-value="form.city"
                            @update:value="form.city = $event"
                            :error="form.errors.city"
                            :disabled="true"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <template v-if="propertyExpenses?.data?.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Payment date</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">Category</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachPropertyExpense, index) in propertyExpenses.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachPropertyExpense.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachPropertyExpense.id) }"
                    @click="selectRow(eachPropertyExpense.id)">
                    <td class="flex-wrap lg:whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ eachPropertyExpense.payment_date }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ eachPropertyExpense.category }}</td>
                    <td class="flex-wrap py-4 text-sm text-gray-500 hidden md:inline-block">{{ eachPropertyExpense.description }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap py-3 text-sm text-gray-500">{{ eachPropertyExpense.payment_amount }}</td>
                    <td class="relative whitespace-nowrap py-4 pr-4 text-right text-sm font-medium sm:pr-0" >
                        <DotsVertical :eachRecord="eachPropertyExpense.id" @submit-form="recordAction"
                                      :allowDuplicate="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--------------------pagination--------------------------->
            <Pagination :pagination="propertyExpenses" />

            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                @onConfirm="deleteRecordConfirmed(deleteRecordId)"
                @onCancel="closeModel"
                :show="modalActive"
                :message="'Are you sure you want to delete this record ' + deleteRecordId + '?'"
                confirmLabel="Yes, delete it!"
                cancelLabel="Cancel"
            />
        </div>
    </template>
    <template v-else>
        <EmptyState @page-Create-Active="createNewRecord" :title="'Property Expense'"/>
    </template>
</div>
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
    propertyExpenses: Object,
    property: Object,
})

const selectedRows = ref([])
const isLoading = ref(false);
const recordId = ref(null);
const deleteRecordId = ref(null);
const modalActive = ref(false)

let form = useForm({
    'id': props.propertyExpenses ? props.propertyExpenses.property_id : '',
    //Property information
    'property_no': props.property ? props.property.property_no : '',
    'address': props.property ? props.property.address : '',
    'city': props.property ? props.property.city : '',

    //Property Expenses information
    'payment_date': props.propertyExpenses ? props.propertyExpenses.payment_date : '',
    'property_expense_category_id': props.propertyExpenses ? props.propertyExpenses.property_expense_category_id : '',
    'description': props.propertyExpenses ? props.propertyExpenses.description : '',
    'payment_amount': props.propertyExpenses ? props.propertyExpenses.payment_amount : '',
    'receipt_id': props.propertyExpenses ? props.propertyExpenses.receipt_id : '',
    'supplier': props.propertyExpenses ? props.propertyExpenses.supplier : '',

    //Property Expenses attachments
    'attachment_file_name': props.propertyExpenses ? props.propertyExpenses.propertyExpense_attachment_files : [],
    'attachment_file': props.propertyExpenses ? props.propertyExpenses.attachment_file : '',
    'attachmentFiles': props.propertyExpenses ? props.propertyExpenses.attachmentFiles : '',
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
    form.post(route('property-expense.store'), {
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
    switch(action) {
        case 'viewRecord':
            router.get(route('property-expense.edit', id))
            break;
        case 'duplicateRecord':
            router.get(route('property-expense.duplicate', id))
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
    router.get(route('property.index'))
}

const createNewRecord = () => {
    router.get(route('property-expense.createPropertyExpense', props.property.id ))
}
const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.delete(route('property-expense.destroy', id))
    modalActive.value = false;
}
</script>
