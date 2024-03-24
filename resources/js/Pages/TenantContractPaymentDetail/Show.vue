<template>
<AuthenticatedLayout :sub-menu="'PROPERTYRENTS'" class="P-2">
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
                    <span class="hidden md:inline-block">Add Rent Payment</span>
                </SecondaryButton>
            </div>

            <div class="p-6  relative border-b border-gray-100 ">
                <div class="lg:flex gap-2 space-y-4 md:space-y-0">
                    <div class="flex-grow">
                        <Editable type="text"
                                  label="Property No"
                                  :input-value="form.property_no"
                                  @update:value="form.property_no = $event"
                                  :error="form.errors.property_no"
                                  :disabled="true"/>
                    </div>
                    <div class="flex-grow">
                        <Editable
                            type="text"
                            label="Address"
                            :input-value="form.address"
                            @update:value="form.address = $event"
                            :error="form.errors.address"
                            :disabled="true"/>
                    </div>
                    <div class="flex-grow">
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

    <template v-if="propertyRents?.data?.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Payment date</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachPropertyRent, index) in propertyRents.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachPropertyRent.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachPropertyRent.id) }"
                    @click="selectRow(eachPropertyRent.id)">
                    <td class="flex-wrap lg:whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ eachPropertyRent.payment_date }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap py-3 text-sm text-gray-500">{{ eachPropertyRent.payment_amount }}</td>
                    <td class="relative whitespace-nowrap py-4 pr-4 text-right text-sm font-medium sm:pr-0" >
                        <DotsVertical :eachRecord="eachPropertyRent.id" @submit-form="recordAction"
                                      :allowDuplicate="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--------------------pagination--------------------------->
            <Pagination :pagination="propertyRents" />

            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                @onConfirm="deleteRecordConfirmed(deleteRecordId)"
                @onCancel="closeModel"
                :show="modalActive"
                :message="'Are you sure you want to delete this Property Rent Amount ?'"
                confirmLabel="Yes, delete it!"
                cancelLabel="Cancel"
            />
        </div>
    </template>
    <template v-else>
        <EmptyState @page-Create-Active="createNewRecord" :title="'Rent Payment'"/>
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
    propertyRents: Object,
    property: Object,
})

const title = ref(null);
const selectedRows = ref([])
const isLoading = ref(false);
const recordId = ref(null);
const deleteRecordId = ref(null);
const modalActive = ref(false)

let form = useForm({
    'id': props.propertyRents ? props.propertyRents.property_id : '',
    //Property information
    'property_no': props.property ? props.property.property_no : '',
    'address': props.property ? props.property.address : '',
    'city': props.property ? props.property.city : '',

    //Property Expenses information
    'payment_amount': props.propertyRents ? props.propertyRents.payment_amount : '',
    'payment_date': props.propertyRents ? props.propertyRents.payment_date : '',
})


let submit = () => {
    form.post(route('property-rent.store'), {
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
            router.get(route('property-rent.edit', id))
            break;
        case 'duplicateRecord':
            router.get(route('property-rent.duplicate', id))
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
    router.get(route('property-rent.createPropertyRent', props.property.id ))
}
const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.delete(route('property-rent.destroy', id))
    modalActive.value = false;
}

const labelClass = ref('block tracking-wide text-gray-700 text-xs font-bold mb-2')
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
