<template>
    <div class="space-y-8 p-4 lg:pl-60 lg:pr-60">
        <form @submit.prevent="submit">
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 pb-4">Tenancy Contract</h2>
                    <XIcon class="flex bg-white text-black  h-6 w-6 ml-4 cursor-pointer" @click="backToList()"/>
                </div>
                <div class="p-6 space-y-4 relative border-b border-gray-100 ">

                    <div class="lg:flex gap-2">
                        <div class="flex-grow">
                            <Editable type="text"
                                      label="First Name"
                                      :input-value="form.first_name"
                                      @update:value="form.first_name = $event"
                                      :error="form.errors.first_name"/>
                        </div>
                        <div class="flex-grow">
                            <Editable
                                type="text"
                                label="Last Name"
                                :input-value="form.last_name"
                                @update:value="form.last_name = $event"
                                :error="form.errors.last_name"/>
                        </div>
                        <div class="flex-grow">
                            <Editable
                                type="text"
                                label="Phone Number 1"
                                :input-value="form.phone_number_1"
                                @update:value="form.phone_number_1 = $event"
                                :error="form.errors.phone_number_1"/>
                        </div>
                        <div class="flex-grow">
                            <Editable
                                type="text"
                                label="Email"
                                :input-value="form.email"
                                @update:value="form.email = $event"
                                :error="form.errors.email"
                            />
                        </div>
                    </div>

                    <!--Upload attachments-->
<!--                    <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6 space-y-4">-->
<!--                        <h2 class="text-sm font-bold">File Attachments</h2>-->
<!--                        <div-->
<!--                            class="flex justify-center rounded-lg border border-dashed border-gray-900/25 px-20 py-4">-->
<!--                            <div class="text-center ">-->
<!--                                <PhotographIcon class="mx-auto h-14 w-14 text-gray-300"/>-->
<!--                                <div id="app" class="z-10">-->
<!--                                    <ul>-->
<!--                                        <li v-for="(file,index) in attachmentFileList" :key="file.id">-->
<!--                                            <a-->
<!--                                                :href="getFileURL(file.attachment_file)" target="_blank">-->
<!--                                                {{ file.attachment_file_name }}-->
<!--                                            </a>-->
<!--                                            <button @click="removeAttachmentFile(index, file.id)"-->
<!--                                                    class="text-red-500">- remove-->
<!--                                            </button>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                    <file-upload-->
<!--                                        input-id="attachment-file"-->
<!--                                        :multiple="true"-->
<!--                                        @input-file="inputAttachmentFile"-->
<!--                                        @input-filter="inputFilter"-->
<!--                                        ref="uploadAttachment"-->
<!--                                        v-model="attachmentFileModel"-->
<!--                                        drop-->
<!--                                        :drop-directory="true"-->
<!--                                    >-->
<!--                                        <div-->
<!--                                            class="mt-4 flex text-sm leading-6 text-gray-600"-->
<!--                                        >-->
<!--                                            <p class="mt-4 text-md" :class="imageClass">Upload a file</p>-->
<!--                                            <p class="pl-1 mt-4">or drag and drop</p>-->
<!--                                        </div>-->
<!--                                    </file-upload>-->
<!--                                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!--Buttons-->
<!--                    <div class="p-6 flex justify-around md:justify-start gap-2 bg-gray-50">-->
<!--                        <div>-->
<!--                            <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"-->
<!--                                           class="px-8 py-2.5">-->
<!--                                Save-->
<!--                            </LoadingButton>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <SecondaryButton @click="showTenantList">-->
<!--                                Cancel-->
<!--                            </SecondaryButton>-->
<!--                        </div>-->
<!--                    </div>-->

                </div>

            </div>
        </form>

        <template v-if="tenantContracts?.data?.length">
            <div class="-mx-4 mt-8 flow-root sm:mx-0">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                        <th scope="col" class="px-10 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:inline-block">Tenant Type</th>
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
                            {{ eachTenantContract.contract_no }}</td>
                        <td class="flex-wrap lg:whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ eachTenantContract.start_date }}</td>
                        <td class="flex-wrap px-10 py-4 text-sm text-gray-500 hidden md:inline-block">{{ eachTenantContract.end_date }}</td>
                        <td class="flex-wrap lg:whitespace-nowrap py-3 text-sm text-gray-500">{{ eachTenantContract.annual_rent }}</td>
                        <td class="relative whitespace-nowrap py-4 pr-4 text-right text-sm font-medium sm:pr-0" >
                            <DotsVertical :eachRecord="eachTenantContract.id" @submit-form="recordAction" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--------------------pagination--------------------------->
                <Pagination :pagination="tenantContracts" />
                <!--------------------pagination--------------------------->
            </div>
        </template>
        <template v-else>
            <EmptyTenantContract @page-Create-Active="pageCreateActive = true"/>
        </template>
        <Create :pageCreateActive="pageCreateActive" @close-modal="pageCreateActive = false"
                :tenantContracts = tenantContracts :properties = properties />
    </div>

</template>

<script setup>
import Editable from "@/Components/Editable.vue";
import {useForm, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon, XIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import DotsVertical from "@/Components/DotsVertical.vue";
import EmptyTenant from "@/Pages/Tenant/EmptyTenant.vue";
import Pagination from "@/Components/Pagination.vue";
import EmptyTenantContract from "@/Pages/TenantContract/EmptyTenantContract.vue";
import Create from "@/Pages/TenantContract/Create.vue";

let props = defineProps({
    tenantContracts: Object,
    properties: Object
})

const pageCreateActive = ref(false)
const isLoading = ref(false);
const recordId = ref(null);


let form = useForm({
    'id': props.tenantContracts ? props.tenantContracts.tenant_id : '',
    //Tenant information
    'first_name': props.tenantContracts ? props.tenantContracts.first_name : '',
    'last_name': props.tenantContracts ? props.tenantContracts.last_name : '',
    'phone_number_1': props.tenantContracts ? props.tenantContracts.phone_number_1 : '',
    'email': props.tenantContracts ? props.tenantContracts.email : '',
    //Tenant contract attachments
    'attachment_file_name': props.tenantContracts ? props.tenantContracts.tenantContract_attachment_files : [],
    'attachment_file': props.tenantContracts ? props.tenantContracts.attachment_file : '',
    'attachmentFiles': props.tenantContracts ? props.tenantContracts.attachmentFiles : '',

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
attachmentFileList.value = form?.attachment_file_name
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
    form.delete(route('tenant-attachment-files.destroy', attachmentFileId), {
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

const recordAction = (id, action) => {
    recordId.value = id;
    console.log(props.recordId)
    switch(action) {
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

const backToList = () => {
    router.get(route('tenant.index'))
}


const labelClass = 'block tracking-wide text-gray-700 text-xs font-bold mb-2'
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
