<template>
<AuthenticatedLayout :sub-menu="'PROPERTYRENTS'">
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
                    <span class="hidden md:inline-block">Add Rent Payment</span>
                </SecondaryButton>
            </div>

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

    </form>

    <template v-if="propertyRents?.data?.length">
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 lg:pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">date</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">Grace Period</th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 ">Late fee</th>
                    <th scope="col" class="relative py-3.5  ">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="border-b border-gray-200"
                    v-for="(eachPropertyRent, index) in propertyRents.data" :key="index"
                    :class="{'bg-gray-100': selectedRow === eachPropertyRent.id, 'divide-y divide-gray-10 ': selectedRows.includes(eachPropertyRent.id) }"
                    @click="selectRow(eachPropertyRent.id)">
                    <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ eachPropertyRent.payment_date }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap lg:py-4 text-sm text-gray-500">{{ eachPropertyRent.payment_amount }}</td>
                    <td class="flex-wrap lg:py-4 text-sm text-gray-500 hidden md:inline-block">{{ eachPropertyRent.grace_period }}</td>
                    <td class="flex-wrap lg:whitespace-nowrap lg:py-4 text-sm text-gray-500">{{ eachPropertyRent.late_fee }}</td>
                    <td class="relative whitespace-nowrap lg:py-4 text-right text-sm font-medium sm:pr-0">
                        <DotsVertical :eachRecord="eachPropertyRent.id" @submit-form="recordAction" />
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
    'late_fee': props.propertyRents ? props.propertyRents.late_fee : '',
    'grace_period': props.propertyRents ? props.propertyRents.grace_period : '',
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
