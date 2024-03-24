<template>
<AuthenticatedLayout :sub-menu="'TENANTCONTRACTS'">
<AppModal :modalActive="modalActive">
    <div class="w-full h-full justify-between border-b border-gray-100 overflow-auto max-h-screen fixed-popup-form">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="p-6 space-y-6 md:space-y-6 relative border-b border-gray-100 ">
                <div class="flex items-center justify-between">
                    <p class="text-xl font-semibold mb-6" v-if="!form.id">Create Tenancy Contract</p>
                    <p class="text-xl font-semibold mb-6" v-if="form.id">Update Tenancy Contract</p>
                    <XIcon class="flex bg-white text-black  h-6 w-6 ml-4 cursor-pointer" @click="cancel()"/>
                </div>

                <TabsWrapper class="md:space-y-10 text-sm md:text-md lg:text-lg">
                    <Tab title="Contract">
<!--                        <ArrowNarrowRightIcon class="w-6 h-5 inline-block section-button-icon text-blue-700"/>-->

                        <div class="pt-4 lg:pt-0">
                            <!--1row-->
                            <div class="lg:flex gap-2  lg:space-y-0">
                                <div class="md:w-6/12">
                                    <Editable type="text"
                                              label="Contract No"
                                              :input-value="form.contract_no"
                                              @update:value="form.contract_no = $event"
                                              :error="form.errors.contract_no" />
                                </div>
                                <div class="md:w-6/12">
                                    <Editable
                                        type="text"
                                        label="Description"
                                        :input-value="form.description"
                                        @update:value="form.description = $event"
                                        :error="form.errors.description"/>
                                </div>
                            </div>
                            <!--2row-->
                            <div class="lg:flex p-2 mb-4 space-y-2 lg:space-y-0">
                                <div class="md:w-3/12">
                                    <!--Radio-->
                                    <div class="flex-grow mt-4 p-4 border md:rounded-md md:p-2">
                                        <p class="labelClass">Residential Tenancy Agreement</p>
                                        <div class="flex justify-between md:space-x-6 mt-4">
                                            <div v-for="agreementType in residentialTenancyAgreements" :key="agreementType.id"
                                                 class="flex items-center">
                                                <input
                                                    type="radio"
                                                    :value="agreementType"
                                                    id="residential_tenancy_agreement"
                                                    v-model="form.residential_tenancy_agreement"
                                                    class="text-blue-600 focus:ring-blue-500"
                                                />
                                                <label :for="agreementType.id"
                                                       class="ml-2 text-sm text-gray-600">{{ agreementType }}</label>
                                            </div>
                                        </div>

                                        <div v-if="form.errors.residential_tenancy_agreement"
                                             v-text="form.errors.residential_tenancy_agreement"
                                             class="text-red-500 text-xs mt-1"></div>
                                    </div>
                                </div>
                            </div>
                            <!--3row-->
                            <div class="lg:w-12/12">
                                <label class="labelClass">
                                    Property No
                                </label>
                                <Multiselect
                                    v-model="selectedState"
                                    :options="properties"
                                    :searchable="true"
                                    placeholder="Select Property No..."
                                    :customLabel="propertyCustomLabel"
                                    track-by="id"
                                    id="property_id"
                                    :multiple="false"
                                />
                                <div v-if="form.errors.property_id" v-text="form.errors.property_id"
                                     class="text-red-500 text-xs mt-1"></div>
                            </div>
                            <!--4row -->
                            <div class="lg:flex gap-2 pt-4">
                                <div class="flex-grow pt-4">
                                    <Editable
                                        type="date"
                                        label="Start Date"
                                        :input-value="form.start_date"
                                        @update:value="form.start_date = $event"
                                        :error="form.errors.start_date" />
                                </div>
                                <div class="flex-grow pt-4">
                                    <Editable
                                        type="date"
                                        label="End Date"
                                        :input-value="form.end_date"
                                        @update:value="form.end_date = $event"
                                        :error="form.errors.end_date" />
                                </div>
                                <div class="flex-grow pt-4">
                                    <Editable
                                        type="text"
                                        label="Total Period"
                                        :input-value="form.total_period"
                                        @update:value="form.total_period = $event"
                                        :error="form.errors.total_period" />
                                </div>
                            </div>
                        </div>
                    </Tab>
                    <Tab title="Payment" class="space-y-6">
                        <!--                3row-->
                        <div class="lg:flex gap-2">
                            <div class="divClass lg:w-1/4">
                                <label class="labelClass">Payment Frequency</label>
                                <MultiselectCustom v-model="form.payment_frequency" :options="paymentFrequency" :initValue="paymentFrequency[0]"/>
                            </div>
                            <div class="divClass lg:w-1/4">
                                <Editable
                                    type="text"
                                    label="Rent Amount"
                                    :placeholder="'0.0'"
                                    :input-value="form.rent_amount"
                                    @update:value="form.rent_amount = $event"
                                    :error="form.errors.rent_amount"/>
                            </div>
                            <div class="lg:w-1/4">
                                <Editable
                                    type="text"
                                    label="Fee Amount"
                                    :placeholder="'0.0'"
                                    :input-value="form.late_fee"
                                    @update:value="form.late_fee = $event"
                                    :error="form.errors.late_fee"/>
                            </div>
                            <div class="lg:w-1/4">
                                <label class="labelClass">Grace Period (Day) </label>
                                <MultiselectCustom v-model="form.grace_period" :options="gracePeriod" :initValue="0"/>
                            </div>
                        </div>
                        <div class="lg:flex lg:space-x-2">
                            <div class="lg:w-2/6">
                                <Editable
                                    label="Security Deposit"
                                    :placeholder="'0.0'"
                                    :input-value="form.security_deposit"
                                    @update:value="form.security_deposit = $event"
                                    :error="form.errors.security_deposit" />
                            </div>
                            <div class="lg:w-2/6">
                                <label class="labelClass">Bills Paid By</label>
                                <MultiselectCustom v-model="form.bills_paid_by" :options="billsPaidBy" />
                            </div>
                            <div class="lg:w-2/6">
                                <Editable
                                    label="Term Of Payment"
                                    :input-value="form.term_of_payment"
                                    @update:value="form.term_of_payment = $event"
                                    :error="form.errors.term_of_payment" />
                            </div>
                        </div>

                        <div class="mt-8 flow-root bg-blue-200 p-6 rounded-md" v-if="form.payment_frequency === 'Monthly'">
                            <p>If invoice is due on the {{gracePeriodDate}} of the month and is not paid in full, a fee of ${{form.late_fee}} will apply on the 2nd of the month.</p>
                        </div>
                        <div class="mt-8 flow-root" v-if="form.payment_frequency === 'Annual'">
                            <table class="min-w-full divide-y divide-gray-300 border-b border-gray-200">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                        Payment date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                        Action
                                    </th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="(item, index) in tenantContractPaymentDetails" :key="index">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 hidden">
                                        <input v-model="item.id" type="text" class="block w-full p-2 border border-gray-300 rounded-md">
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <input v-model="item.payment_date" type="date" placeholder="Payment Date" class="block w-full p-2 border border-gray-300 rounded-md">
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <input v-model="item.payment_amount" type="number" placeholder="Payment Amount" class="block w-full p-2 border border-gray-300 rounded-md">
                                    </td>
                                    <td class="px-6 py-4 text-grey-700">
                                        <button @click.prevent="removeItem(index,item.id)" class="py-1 px-3 text-white bg-red-500 hover:bg-red-700 rounded">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="py-4 text-grey-700 text-center">
                                        <button @click.prevent="addItem" class="py-1 lg:px-10 text-white bg-blue-500 hover:bg-blue-700 rounded">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </Tab>
                    <Tab title="Other" class="space-y-4">
                        <!--6row-->
                        <div class="w-full">
                            <Editable
                                type="textarea"
                                label="Note"
                                :input-value="form.note"
                                @update:value="form.note = $event"
                                :error="form.errors.note" />
                        </div>
                        <!--Upload attachments-->
                        <div>
                            <h2 class="ml-4 text-sm font-bold">File Attachments</h2>
                            <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                                <div
                                    class="flex justify-center rounded-lg border border-dashed border-gray-900/25 lg:px-20 py-4">
                                    <div class="text-center">
                                        <PhotographIcon class="mx-auto h-10 w-10 text-gray-300"/>
                                        <div id="app" class="z-10">
                                            <ul>
                                                <li v-for="(file,index) in attachmentFileList" :key="file.id">
                                                    <a
                                                        :href="getFileURL(file.attachment_file)" target="_blank">
                                                        {{ file.attachment_file_name }}
                                                    </a>
                                                    <button @click="removeAttachmentFile(index, file.id)"
                                                            class="text-red-500">- remove
                                                    </button>
                                                </li>
                                            </ul>
                                            <file-upload
                                                input-id="attachment-file"
                                                :multiple="true"
                                                @input-file="inputAttachmentFile"
                                                @input-filter="inputFilter"
                                                ref="uploadAttachment"
                                                v-model="attachmentFileModel"
                                                drop
                                                :drop-directory="true"
                                            >
                                                <div
                                                    class="mt-4 flex text-sm leading-6 text-gray-600 cursor-pointer"
                                                >
                                                    <p class="text-md imageClass">Upload a file</p>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                            </file-upload>
                                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-around md:justify-end space-x-2 bg-gray-50">
                            <div class="w-full md:w-auto">
                                <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                                               class="px-8 h-full">
                                    Save
                                </LoadingButton>
                            </div>
                            <div class="w-full md:w-auto">
                                <SecondaryButton @click="cancel" class="w-full">
                                    Cancel
                                </SecondaryButton>
                            </div>
                        </div>

                    </Tab>
                    <!--Buttons fixed-popup-form-->
                </TabsWrapper>
            </div>

            <!--------------------Popup Confirmation Delete--------------------------->
            <ConfirmationModal
                :showCancelButton="true"
                :showConfirmButton="false"
                @onCancel="closeModel"
                :show="popUpModalActive"
                :message="'Please review each tab carefully. There is at least one error or missing value!'"
                cancelLabel="Cancel"
            />
            <!--------------------Popup Confirmation Delete--------------------------->

        </div>
    </form>
</div>
</AppModal>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Editable from "@/Components/Editable.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref, watch, computed} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon, XIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";
import MultiselectCustom from "@/Components/MultiselectCustom.vue";
import TabsWrapper from "@/Components/Partials/TabsWrapper.vue";
import Tab from "@/Components/Partials/Tab.vue";
import { ArrowNarrowRightIcon } from '@heroicons/vue/outline';
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";
import Pagination from "@/Components/Pagination.vue";


let props = defineProps({
    tenantContracts: Object,
    properties: Object,
    tenantContractPaymentDetails: Object,
    tenant_id: {
        type: [Number, String]
    },
})

const modalActive = ref(true)
const isLoading = ref(false)
const popUpModalActive = ref(false)

let form = useForm({
    'id': props.tenantContracts ? props.tenantContracts.id : '',
    'tenant_id': props.tenantContracts ? props.tenantContracts.tenant_id : props.tenant_id,
    'property_id': props.tenantContracts ? props.tenantContracts.property_id : '',

    'contract_no': props.tenantContracts ? props.tenantContracts.contract_no : '',
    'residential_tenancy_agreement': props.tenantContracts ? props.tenantContracts.residential_tenancy_agreement : 'Initial',
    'description': props.tenantContracts ? props.tenantContracts.description : '',
    'monthly_payment_date': props.tenantContracts ? props.tenantContracts.monthly_payment_date : '',
    'late_fee': props.tenantContracts ? props.tenantContracts.late_fee : '0',
    'grace_period': props.tenantContracts ? props.tenantContracts.grace_period : '0',
    'document_id': props.tenantContracts ? props.tenantContracts.document_id : '',
    'start_date': props.tenantContracts ? props.tenantContracts.start_date : '',
    'end_date': props.tenantContracts ? props.tenantContracts.end_date : '',
    'total_period': props.tenantContracts ? props.tenantContracts.total_period : '',
    'payment_frequency': props.tenantContracts ? props.tenantContracts.payment_frequency : 'Monthly',
    'rent_amount': props.tenantContracts ? props.tenantContracts.rent_amount : '0',
    'term_of_payment': props.tenantContracts ? props.tenantContracts.term_of_payment : '',
    'security_deposit': props.tenantContracts ? props.tenantContracts.security_deposit : 0,
    'bills_paid_by': props.tenantContracts ? props.tenantContracts.bills_paid_by : '',
    'note': props.tenantContracts ? props.tenantContracts.note : '',

    'tenant_contract_id': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.tenant_contract_payment_details : [],
    'payment_date': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.payment_date : '',
    'payment_amount': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.payment_amount : '',
    // 'paymentDetails': props.tenantContracts ? props.tenantContracts.paymentDetails : [],

    'attachment_file_name': props.tenantContracts ? props.tenantContracts.tenant_contract_attachment_files : [],
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

const attachmentFileList = ref([])
attachmentFileList.value = form?.attachment_file_name || []
const attachmentFileModel = ref([])

const getFileURL = (url) => {
    return url.startsWith('blob') ? url : `/storage/${url.slice(7)}`
}
const inputAttachmentFile = () => {
    form.attachmentFiles = attachmentFileModel.value.map(file => file.file)
    for (let i = 0; i < attachmentFileModel.value.length; i++) {
        if (!attachmentFileList.value.find(file => file.id === attachmentFileModel.value[i].id)) {
            const file = attachmentFileModel.value[i];
            attachmentFileList.value.push({
                id: file.id,
                attachment_file_name: file.name,
                attachment_file: URL.createObjectURL(file.file)
            });
        }
    }
}
const removeAttachmentFile = (index, attachmentFileId) => {
    attachmentFileList.value.splice(index, 1)
    attachmentFileModel.value.splice(attachmentFileModel.value.findIndex(file => file.id === attachmentFileId), 1)
    form.attachmentFiles = attachmentFileModel.value.map(file => file.file)
    form.delete(route('tenant-contract-attachment-files.destroy', attachmentFileId), {
        preserveScroll: true,
    })
}







// create array for payment_date & payment_amount

const paymentDetailList = ref(props.tenantContractPaymentDetails || [])

const addItem = () => {
    let newItem = {id: '', payment_date: new Date(), payment_amount: 0 }
    paymentDetailList.value.push(newItem)
}
const removeItem = (index, id) => {
    console.log(id)
    if (id){
        form.delete(route('tenant-contract-payment-detail.destroy', id))
        window.location.reload()
    }
    paymentDetailList.value.splice(index, 1);
}





// manage multiselect data
const selectedState = ref([])
selectedState.value = props.properties.find(e => e.id === form.property_id)
watch(selectedState, (newState) => {
    form.property_id = newState ? newState.id : null;
});
const propertyCustomLabel = (property) => {
    return `${property.property_no} - ${property.name} - ${property.address}`;
};

// Submit or cancel form submission
let submit = () => {
    form.tenant_contract_id = paymentDetailList.value;
    form.post(route('tenant-contract.store'), {
        onStart: () => {
            isLoading.value = true
        },
        onError: () => {
            popUpModalActive.value = true;
            isLoading.value = false
        },
        onSuccess: () => {
            form.clearErrors()
        },
    })
}
const closeModel = () => {
    popUpModalActive.value = false;
}

const cancel = () => {
    form.get(route('tenant-contract.show',
        (props.tenantContracts && props.tenantContracts.tenant_id) ?
            props.tenantContracts.tenant_id :  props.tenant_id))
}

// // List of values
const billsPaidBy = ref(['Tenant ', 'Owner'])
const residentialTenancyAgreements = ref(['Initial', 'Renewal'])
const gracePeriod = ref([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31])
const paymentFrequency = ref(['Monthly', 'Annual'])

//Calculation
const gracePeriodDate = computed(() => {
    const date = Number(form.grace_period) + 2;
    if (date === 1 || date === 21 || date === 31) {
        return date + "st";
    } else if (date === 2 || date === 22) {
        return date + "nd";
    } else if (date === 3 || date === 23) {
        return date + "rd";
    } else {
        return date + "th";
    }
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.fixed-popup-form {
    width: 100%; /* You can adjust as per your requirement */
    height: 70vh; /* Adjust as per your requirement */
}
</style>
