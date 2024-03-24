<template>
<AuthenticatedLayout :sub-menu="'TENANTCONTRACTS'">
<AppModal :modalActive="modalActive">
    <div class="w-full h-full justify-between border-b border-gray-100 overflow-auto max-h-screen">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="p-6 space-y-6 md:space-y-6 relative border-b border-gray-100 ">
                <p class="text-xl font-semibold mb-6" v-if="!form.id">Create Tenancy Contract</p>
                <p class="text-xl font-semibold mb-6" v-if="form.id">Update Tenancy Contract</p>

                <div>
                    <div class="hidden sm:block">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <a v-for="tab in tabs"
                               :key="tab.name"
                               @click.prevent="setActiveTab(tab)"
                               :href="tab.href"
                               :class="[tab.current ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 ' +
                                'hover:text-gray-700', 'rounded-md px-3 py-2 text-sm font-medium']"
                               :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</a>
                        </nav>
                    </div>
                </div>

                <!--1row-->
                <template v-if="tabs[0].current">
                <div class="lg:flex gap-2">
                    <div class="w-6/12">
                        <Editable type="text"
                              label="Contract No"
                              :input-value="form.contract_no"
                              @update:value="form.contract_no = $event"
                              :error="form.errors.contract_no" />
                    </div>
                    <div class="w-4/12 pr-4">
                        <Editable
                            type="text"
                            label="Description"
                            :input-value="form.description"
                            @update:value="form.description = $event"
                            :error="form.errors.description"/>
                    </div>
                    <div class="md:w-3/12">
                        <!--Radio-->
                        <div class="flex-grow mt-4 p-4 border md:rounded-md md:p-2">
                            <p :class="labelClass">Residential Tenancy Agreement</p>
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
                </template>
                <!--2row-->
                <template v-else-if="tabs[1].current">
                <div>
                    <label class="labelClass">
                        Property No {{form.property_id}}
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
                </template>
<!--                3row-->
                <template v-else-if="tabs[2].current">
                <div class="lg:flex gap-2">
                    <div :class="`${divClass} flex-grow`">
                        <label :class="labelClass">Payment Frequency</label>
                        <MultiselectCustom v-model="form.payment_frequency" :options="paymentFrequency" :initValue="paymentFrequency[0]"/>
                    </div>
                    <div>
                        <Editable
                            type="text"
                            label="Rent Amount"
                            :input-value="form.rent_amount"
                            @update:value="form.rent_amount = $event"
                            :error="form.errors.rent_amount"/>
                    </div>
                    <div>
                        <Editable
                            type="text"
                            label="Fee Amount"
                            :input-value="form.late_fee"
                            @update:value="form.late_fee = $event"
                            :error="form.errors.late_fee"/>
                    </div>
                    <div :class="`${divClass} flex-grow`">
                        <label :class="labelClass">Grace Period (Day) </label>
                        <MultiselectCustom v-model="form.grace_period" :options="gracePeriod" :initValue="0"/>
                    </div>
                </div>
                </template>

                <!--4row -->
                <template v-else-if="tabs[3].current">
                <div class="lg:flex gap-2">
                    <div class="flex-grow">
                        <Editable
                            type="date"
                            label="Start Date"
                            :input-value="form.start_date"
                            @update:value="form.start_date = $event"
                            :error="form.errors.start_date" />
                    </div>
                    <div class="flex-grow">
                        <Editable
                            type="date"
                            label="End Date"
                            :input-value="form.end_date"
                            @update:value="form.end_date = $event"
                            :error="form.errors.end_date" />
                    </div>
                    <div>
                        <Editable
                            type="text"
                            label="Total Period"
                            :input-value="form.total_period"
                            @update:value="form.total_period = $event"
                            :error="form.errors.total_period" />
                    </div>
                    <div>
                        <Editable
                            label="Security Deposit"
                            :input-value="form.security_deposit"
                            @update:value="form.security_deposit = $event"
                            :error="form.errors.security_deposit" />
                    </div>
                </div>
                <!--5row-->
                <div class="lg:flex gap-2">
                    <div class="flex-grow">
                        <Editable
                            label="Term Of Payment"
                            :input-value="form.term_of_payment"
                            @update:value="form.term_of_payment = $event"
                            :error="form.errors.term_of_payment" />
                    </div>
                    <div :class="`${divClass} md:w-3/12`">
                        <label :class="labelClass">Bills Paid By</label>
                        <MultiselectCustom v-model="form.bills_paid_by" :options="billsPaidBy" />
                    </div>
                </div>
                <!--6row-->
                <div class="w-full">
                    <Editable
                        type="textarea"
                        label="Note"
                        :input-value="form.note"
                        @update:value="form.note = $event"
                        :error="form.errors.note" />
                </div>
                </template>
            </div>

            <!--Upload attachments-->
            <div class="space-y-2">
                <h2 class="ml-4 text-sm font-bold">File Attachments</h2>
                <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                    <div
                        class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 lg:px-20 py-4">
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
                                        class="mt-4 flex text-sm leading-6 text-gray-600"
                                    >
                                        <p class="mt-4 text-md" :class="imageClass">Upload a file</p>
                                        <p class="pl-1 mt-4">or drag and drop</p>
                                    </div>
                                </file-upload>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Buttons-->
        <div class="p-6 flex justify-around md:justify-start gap-2 bg-gray-50">
            <div>
                <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                               class="px-8 py-2.5">
                    Save
                </LoadingButton>
            </div>
            <!--{{ properties}}-->
            <div>
                <SecondaryButton @click="cancel">
                    Cancel
                </SecondaryButton>
            </div>
        </div>
    </form>
</div>
</AppModal>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Editable from "@/Components/Editable.vue";
import {useForm} from "@inertiajs/vue3";
import {reactive, ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";
import MultiselectCustom from "@/Components/MultiselectCustom.vue";
import {Tab, TabGroup} from "@headlessui/vue";

let props = defineProps({
    tenantContracts: Object,
    properties: Object,
    tenant_id: {
        type: [Number, String]
    },
})

const modalActive = ref(true)
const isLoading = ref(false)

let form = useForm({
    'id': props.tenantContracts ? props.tenantContracts.id : '',
    'tenant_id': props.tenantContracts ? props.tenantContracts.tenant_id : props.tenant_id,
    'property_id': props.tenantContracts ? props.tenantContracts.property_id : '',

    'contract_no': props.tenantContracts ? props.tenantContracts.contract_no : '',
    'residential_tenancy_agreement': props.tenantContracts ? props.tenantContracts.residential_tenancy_agreement : '',
    'description': props.tenantContracts ? props.tenantContracts.description : '',
    'late_fee': props.tenantContracts ? props.tenantContracts.late_fee : '',
    'grace_period': props.tenantContracts ? props.tenantContracts.grace_period : 0,
    'document_id': props.tenantContracts ? props.tenantContracts.document_id : '',
    'start_date': props.tenantContracts ? props.tenantContracts.start_date : '',
    'end_date': props.tenantContracts ? props.tenantContracts.end_date : '',
    'total_period': props.tenantContracts ? props.tenantContracts.total_period : '',
    'payment_frequency': props.tenantContracts ? props.tenantContracts.payment_frequency : '',
    'rent_amount': props.tenantContracts ? props.tenantContracts.rent_amount : '',
    'term_of_payment': props.tenantContracts ? props.tenantContracts.term_of_payment : '',
    'security_deposit': props.tenantContracts ? props.tenantContracts.security_deposit : '',
    'bills_paid_by': props.tenantContracts ? props.tenantContracts.bills_paid_by : '',
    'note': props.tenantContracts ? props.tenantContracts.note : '',

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

const cancel = () => {
    form.get(route('tenant-contract.show',
        (props.tenantContracts && props.tenantContracts.tenant_id) ?
            props.tenantContracts.tenant_id :  props.tenant_id))
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

// // List of values
const billsPaidBy = ref(['Tenant ', 'Owner'])
const residentialTenancyAgreements = ref(['Initial', 'Renewal'])
const gracePeriod = ref([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31])
const paymentFrequency = ref(['Monthly', 'Annual'])

// Using Tabs option
// let setActiveTab = (tab) => {
//     console.log(`Tab clicked: ${tab.name}`);
//     tabs.forEach(t => t.current = false);
//     tab.current = true;
// }

let setActiveTab = undefined;
let tabs = undefined;

setActiveTab = (tab) => {
    console.log(`Tab clicked: ${tab.name}`);
    tabs = tabs.map(t => {
        const isCurrent = t.name === tab.name;
        return {
            ...t,
            current: isCurrent,
        };
    });
    console.log('Updated tabs: ', tabs);
};

tabs = reactive([
    { name: 'Contract information', href: '#', current: true},
    { name: 'Property', href: '#', current: false},
    { name: 'Payment', href: '#', current: false},
    { name: 'Others', href: '#', current: false},
]);

//classes to be moved
const labelClass = 'block tracking-wide text-gray-700 text-xs font-bold mb-2'
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')
const divClass = ref('sm:grid sm:grid-cols-1 sm:items-start');

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
