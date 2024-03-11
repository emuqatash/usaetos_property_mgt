<template>
<AuthenticatedLayout :sub-menu="'TENANTCONTRACTS'" class="P-2">
<AppModal :modalActive="modalActive">
    <div class="w-full h-full p-4 flex justify-between border-b border-gray-100 overflow-auto max-h-screen">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="p-6 space-y-6 md:space-y-2 relative border-b border-gray-100 ">
                <p class="text-xl font-semibold mb-6">Create or Edit Tenancy Contract</p>
                <!--1row-->
                <div class="lg:flex gap-10">
                    <div class="w-8/12">
                        <Editable type="text"
                              label="Contract No"
                              :input-value="form.contract_no"
                              @update:value="form.contract_no = $event"
                              :error="form.errors.contract_no" />
                    </div>
                    <div>
                        <!--Radio-->
                        <div class="flex-grow mt-4 md:mt-0">
                            <p :class="labelClass">Residential Tenancy Agreement</p>
                            <div class="md:flex md:space-x-6 mt-4">
                                <div v-for="agreementType in residential_tenancy_agreements" :key="agreementType.id"
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
                <!--2row-->
                <div>
                    <label class="labelClass">
                        Property No {{form.property_id}}
                    </label>
                    <Multiselect
                        v-model="selectedProperty"
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
                <!--3row-->
                <div class="flex-grow">
                    <Editable
                        type="text"
                        label="Description"
                        :input-value="form.description"
                        @update:value="form.description = $event"
                        :error="form.errors.description"/>
                </div>
                <!--4row-->
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
                    <div class="flex-grow">
                        <Editable
                            type="text"
                            label="Total Period"
                            :input-value="form.total_period"
                            @update:value="form.total_period = $event"
                            :error="form.errors.total_period" />
                    </div>
                    <div class="flex-grow">
                        <Editable
                            type="text"
                            label="Monthly Rent"
                            :input-value="form.monthly_rent"
                            @update:value="form.monthly_rent = $event"
                            :error="form.errors.monthly_rent" />
                    </div>
                </div>
                <!--5row-->
                <div class="lg:flex gap-2">
                    <div class="flex-grow">
                        <Editable
                            label="Annual Rent"
                            :input-value="form.annual_rent"
                            @update:value="form.annual_rent = $event"
                            :error="form.errors.annual_rent" />
                    </div>
                    <div class="flex-grow">
                        <Editable
                            label="Term Of Payment"
                            :input-value="form.term_of_payment"
                            @update:value="form.term_of_payment = $event"
                            :error="form.errors.term_of_payment" />
                    </div>
                    <div class="flex-grow">
                        <Editable
                            label="Security Deposit"
                            :input-value="form.security_deposit"
                            @update:value="form.security_deposit = $event"
                            :error="form.errors.security_deposit" />
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
import {onMounted, ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";
import MultiselectCustom from "@/Components/MultiselectCustom.vue";

let props = defineProps({
    tenantContracts: Object,
    properties: Object,
    tenant_id: {
        type: [Number, String]
    },
})

const modalActive = ref(true)
const isLoading = ref(false)
const selectedProperty = ref([])

let form = useForm({
    'id': props.tenantContracts ? props.tenantContracts.id : '',
    'tenant_id': props.tenantContracts ? props.tenantContracts.tenant_id : props.tenant_id,
    'property_id': props.tenantContracts ? props.tenantContracts.property_id : '',

    'contract_no': props.tenantContracts ? props.tenantContracts.contract_no : '',
    'residential_tenancy_agreement': props.tenantContracts ? props.tenantContracts.residential_tenancy_agreement : '',
    'description': props.tenantContracts ? props.tenantContracts.description : '',
    'document_id': props.tenantContracts ? props.tenantContracts.document_id : '',
    'start_date': props.tenantContracts ? props.tenantContracts.start_date : '',
    'end_date': props.tenantContracts ? props.tenantContracts.end_date : '',
    'total_period': props.tenantContracts ? props.tenantContracts.total_period : '',
    'annual_rent': props.tenantContracts ? props.tenantContracts.annual_rent : '',
    'monthly_rent': props.tenantContracts ? props.tenantContracts.monthly_rent : '',
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

selectedProperty.value = props.properties.find(e => e.property_id === form.property_id)
watch(selectedProperty, (newState) => {
    form.property_id = newState ? newState.id : null;
});

const propertyCustomLabel = (property) => {
    return `${property.property_no} - ${property.name} - ${property.address}`;
};

// // List of values
const billsPaidBy = ref(['Tenant ', 'Owner'])
const residential_tenancy_agreements = ref(['Initial', 'Renewal'])

const labelClass = 'block tracking-wide text-gray-700 text-xs font-bold mb-2'
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')
const divClass = ref('sm:grid sm:grid-cols-1 sm:items-start');

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
