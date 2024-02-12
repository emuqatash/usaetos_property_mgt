<template>
    <AuthenticatedLayout :sub-menu="'false'">
        <div class="lg:flex lg:justify-between items-center lg:mb-8 lg:w-ful lg:-ml-64 lg:-mr-60 border-b">
            <SecondaryButton class="w-28 lg:w-20 lg:h-10 lg:-ml-28 font-bold text-black" @click="showJobList">
                <ArrowLeftIcon class="font-semibold text-gray-600 w-5"/>
                Back
            </SecondaryButton>
            <div class="lg:flex lg:justify-between lg:items-center xl:-ml-80 hidden">
                <div class="flex flex-col items-center justify-center">
                    <FolderIcon class="lg:-mt-3 w-16 h-16 text-gray-200">
                    </FolderIcon>
                    <p class="lg:-mt-1 text-sm text-gray-600">{{ form.job_number }}</p>
                </div>
                <div class="border-l">
                    <p class="w-32 text-sm text-black ml-2 font-bold">{{ form.job_location }}</p>
                    <p class="mt-2 text-sm text-gray-600 ml-2">{{ contactName }}</p>
                </div>
            </div>

            <div class="lg:flex lg:justify-between lg:space-x-2 mt-2 font-semibold">
                <div>
                    <JobStatusDropdown
                        @selectStatus="handleStatusChange"
                        :status="form.job_status"
                    />
                </div>
                <div class="flex mt-2 sm:col-span-2 sm:mt-0">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300
                                focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <div class="flex items-center">
                            <MultiSelectDropdown
                                :salesmen="salesmen"
                                :selected="selected"
                                class="w-44"
                                :buttonLabel="buttonLabel"
                                @emitSelection="handleSelection"
                            />
                        </div>
                    </div>
                </div>
                <!-- Add a container -->
                <div class="flex mt-2 lg:mt-0 space-x-4 lg:space-x-0">
                    <SecondaryButton class="font-semibold lg:mr-2 w-full cursor-pointer z-10" @click="handleJobEdit">
                        Edit
                    </SecondaryButton>
                    <SecondaryButton class="font-semibold w-full z-10">
                        <PrinterIcon class="w-5 h-5 mr-2 inline-block section-button-icon text-gray-400"/>
                        <span class="lg:inline-block">Print</span>
                    </SecondaryButton>
                </div>
            </div>
        </div>

        <div class="lg:flex mt-2 lg:-mt-0">
            <div>
                <div>
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-black"> Job Information</h1>
                        <p class="mt-2 text-sm text-gray-600">Below are the basic details included for this job.
                            Sold.</p>
                    </div>
                </div>
                <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y">
                    <div :class="divClass">
                        <label :class="labelClass">Job Number</label>
                        <div :class="divInputClass">
                            <span :class="inputClass">{{ form.job_number }}</span>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label :class="labelClass">Customer</label>
                        <div :class="divInputClass">
                            <span :class="inputClass">{{ contactName }}</span>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label :class="labelClass">Job Location</label>
                        <div :class="divInputClass">
                            <span :class="inputClass">{{ form.job_location }}</span>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label :class="labelClass">Roof Type</label>
                        <div :class="divInputClass">
                            <span :class="inputClass">{{ form.roof_type }}</span>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label :class="labelClass">Insurance Agent/Adjuster</label>
                        <div :class="divInputClass">
                            <span :class="inputClass"> {{ form.insurance_agent?.agent_name }}</span>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label :class="labelClass">Insurance Claim Number</label>
                        <div :class="divInputClass">
                            <span :class="inputClass">{{ form.insurance_claim_number }}</span>
                        </div>
                    </div>
                </div>

                <h1 class="text-base font-semibold leading-6 text-gray-900 mt-10 mb-8">Job Documents</h1>
                <div class="space-y-6">
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Job Specifications</p>
                        <p class="text-sm font-medium text-gray-500 mb-8">Specifications provide a basic overview of the
                            job to be performed.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <SecondaryButton v-if="form.specification === null" class="text-lg px-6 font-semibold" @click="handleCreateSpecification">Create</SecondaryButton>
                            <SecondaryButton v-if="form.specification != null" class="text-lg px-6 font-semibold" @click="handleEditSpecification">Edit</SecondaryButton>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Estimate</p>
                        <p class="text-sm font-medium text-gray-500 mb-8"> Estimates show how much you will charge
                            the
                            customer.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <AppButton class="text-lg font-semibold">
                                <LinkIcon class="w-7 h-7 mr-2"/>
                                Link Estimate
                            </AppButton>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Contract</p>
                        <p class="text-sm font-medium text-gray-500 mb-8"> Contracts outline the work to be
                            performed.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <AppButton class="text-lg font-semibold">
                                <LinkIcon class="w-7 h-7 mr-2"/>
                                Link Contract
                            </AppButton>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Invoice</p>
                        <p class="text-sm font-medium text-gray-500 mb-8">Invoices maintain a monetary record of the
                            business
                            transaction.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <AppButton class="text-lg font-semibold">
                                <LinkIcon class="w-7 h-7 mr-2"/>
                                Link Invoice
                            </AppButton>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Purchase Order</p>
                        <p class="text-sm font-medium text-gray-500 mb-8">Purchase Orders formalize the pricing and
                            materials
                            required to complete the job.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <AppButton class="text-lg font-semibold">
                                <LinkIcon class="w-7 h-7 mr-2"/>
                                Link PO
                            </AppButton>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                        <p class="text-xl font-bold text-black sm:text-2xl">Permit</p>
                        <p class="text-sm font-medium text-gray-500 mb-8">Permits are official permission or
                            authorization to do the work.</p>
                        <div class="divide-y sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                    <PhotographIcon class="mx-auto h-14 w-14 text-gray-300"/>
                                    <div id="app" class="z-10">
                                        <ul>
                                            <li v-for="(file,index) in permitFileList" :key="file.id">
                                                <a
                                                    :href="`/storage/${file.permit_file.slice(7)}`" target="_blank">
                                                    {{ file.permit_file_name }}
                                                </a>
                                                <button @click="removePermitFile(index, file.id)"
                                                        class="text-red-500">- remove
                                                </button>
                                            </li>
                                        </ul>
                                        <file-upload
                                            input-id="permit-file"
                                            :multiple="true"
                                            @input-file="inputPermitFile"
                                            @input-filter="inputFilter"
                                            ref="uploadPermit"
                                            v-model="permitFileModel"
                                            drop
                                            :drop-directory="true"
                                        >
                                            <div
                                                class="mt-4 flex text-sm leading-6 text-gray-600"
                                            >
                                                <p class="mt-4 text-md" :class="imageClas">Upload a file</p>
                                                <p class="pl-1 mt-4">or drag and drop</p>
                                            </div>
                                        </file-upload>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                        <div v-if="form.errors.permitFiles" v-text="form.errors.permitFiles"
                                             class="text-red-500 text-xs mt-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-black sm:text-2xl">File Attachments</p>
                    <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                        <div
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center ">
                                <PhotographIcon class="mx-auto h-14 w-14 text-gray-300"/>
                                <div id="app" class="z-10">
                                    <ul>
                                        <li v-for="(file,index) in attachmentFileList" :key="file.id">
                                            <a
                                                :href="`/storage/${file.attachment_file.slice(7)}`" target="_blank">
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
                                            <p class="mt-4 text-md" :class="imageClas">Upload a file</p>
                                            <p class="pl-1 mt-4">or drag and drop</p>
                                        </div>
                                    </file-upload>
                                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    <div v-if="form.errors.permitFiles" v-text="form.errors.permitFiles"
                                         class="text-red-500 text-xs mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-11/12 2xl:w-8/12 lg:-mr-28">
                <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow p-6">
                        <div>
                            <p class="text-md font-bold text-black">Summary</p>
                            <p class="text-sm font-bold text-black sm:text-xl"> - - </p>
                        </div>
                        <div class="flex space-x-2 mt-6 mb-4">
                            <IdentificationIcon class="h-5 w-5 text-gray-400"/>
                            <p class="text-sm font-medium text-gray-500">{{ contactName }}</p>
                        </div>
                        <div class="flex space-x-2 mb-4">
                            <HomeIcon class="h-5 w-5 text-gray-400"/>
                            <p class="text-sm font-medium text-gray-500 ">{{ form.job_location }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <ClockIcon class="h-5 w-5 text-gray-400"/>
                            <p class="text-sm font-medium text-gray-500"> - - </p>
                        </div>
                        <div>
                            <div
                                class="flex mt-6 pt-6 justify-between border-t divide-y sm:divide-x sm:divide-y-0">
                                <p class="text-sm font-bold text-black">Download Summary</p>
                                <DownloadIcon class="h-5 w-5"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {
    LinkIcon, PhotographIcon, PrinterIcon,
    FolderIcon, ArrowLeftIcon, DownloadIcon, HomeIcon, ClockIcon, IdentificationIcon,
} from "@heroicons/vue/solid";
import {computed, onMounted, ref, watch} from "vue";
import AppButton from "@/Components/AppButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import JobStatusDropdown from "@/Components/AppComponents/JobStatusDropdown.vue";

let props = defineProps({
    job: Object,
    contact: Object,
    selectedSalesmen: Array,
    salesmen: Array,
})

const form = useForm({
    ...props.job,
    'permitFiles': '',
    'attachmentFiles': ''
})

const buttonLabel = ref('Assignees')

const selected = ref([]);

onMounted(() => {
    selected.value = props.selectedSalesmen.map(salesman => salesman.id);
});
const showJobList = () => {
    router.get(route('jobs.index', {jobStatus: form.job_status}))
}

const contactName = computed(() => `${props.contact.first_name} ${props.contact.last_name}`)

const handleStatusChange = (status) => {
    form.job_status = status;
    form.put(route('jobs.update', form.id))
}
const handleSelection = (ids) => {
    form.salesman_ids = ids;
    form.put(route('jobs.update', form.id))
}
const handleJobEdit = () => {
    form.get(route('jobs.edit', form.id))
}

const handleCreateSpecification = () => {
    form.get(route('specifications.create', form.id ))
}

const handleEditSpecification = () => {
    form.get(route('specifications.edit', form.id ))
}

/// upload Multiple Permit files
/// Front-end validation
const inputFilter = (newFile, oldFile, prevent) => {
    if (newFile && !oldFile) {
        const MAX_FILE_SIZE_MB = 10
        const fileSizeMB = newFile.size / (1024 * 1024);
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
            alert('File type must be jpeg, jpe, jpg, gif, png or webp');
            return prevent();
        }
        if (fileSizeMB > MAX_FILE_SIZE_MB) {
            alert('File size should not be more than ' + MAX_FILE_SIZE_MB + ' MB');
            return prevent();
        }
    }
}

// handle upload Permit files
const permitFileList = ref([])
permitFileList.value = form?.job_permit_files
watch(() => props.job, (newState) => {
    permitFileList.value = newState.job_permit_files ? newState.job_permit_files : []
    permitFileModel.value = []
});
const permitFileModel = ref([])
const inputPermitFile = () => {
    form.permitFiles = permitFileModel.value.map(file => file.file)
    form.post(route('jobs.store'), {
        preserveScroll: true,
    })
}
const removePermitFile = (index, permitFileId) => {
    permitFileList.value.splice(index, 1)
    form.delete(route('job-permit-files.destroy', permitFileId), {
        preserveScroll: true,
    })
}

// handle upload attachment files
const attachmentFileList = ref([])
attachmentFileList.value = form?.job_attachment_files
watch(() => props.job, (newState) => {
    attachmentFileList.value = newState.job_attachment_files ? newState.job_attachment_files : []
    attachmentFileModel.value = []
});
const attachmentFileModel = ref([])
const inputAttachmentFile = () => {
    form.attachmentFiles = attachmentFileModel.value.map(file => file.file)
    form.post(route('jobs.store'), {
        preserveScroll: true,
    })
}
const removeAttachmentFile = (index, attachmentFileId) => {
    attachmentFileList.value.splice(index, 1)
    form.delete(route('job-attachment-files.destroy', attachmentFileId), {
        preserveScroll: true,
    })
}

const labelClass = ref('labelClass');
const inputClass = ref('relative w-full cursor-default bg-transparent py-1.5 pr-10 text-left')
const divClass = ref('sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6')
const divInputClass = ref('sm:max-w-md')
const imageClas = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')
</script>
<style>
.file-uploads.file-uploads-html4 input, .file-uploads.file-uploads-html5 label {
    cursor: pointer;
}
</style>
