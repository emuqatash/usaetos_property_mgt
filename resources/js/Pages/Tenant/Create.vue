<template>
    <AuthenticatedLayout :sub-menu="'TENANTS'">
        <!-- Modal -->
        <AppModal :modalActive="modalActive">
            <div class="overflow-y-auto h-screen md:h-auto">
                <form @submit.prevent="submit">
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <div class="lg:flex">
                        <div class="p-7 relative border-b border-gray-100 space-y-4">
                            <p class=" text-xl font-semibold mb-6">Create Tenant</p>

                            <div class="lg:flex gap-2">
                                <div>
                                    <Editable type="text"
                                              label="First Name"
                                              :input-value="form.first_name"
                                              @update:value="form.first_name = $event"
                                              :error="form.errors.first_name"
                                              required/>
                                </div>
                                <div>
                                    <Editable
                                        type="text"
                                        label="Last Name"
                                        :input-value="form.last_name"
                                        @update:value="form.last_name = $event"
                                        :error="form.errors.last_name"
                                        required/>
                                </div>
                            </div>

                            <div class="lg:flex gap-2">
                                <div>
                                    <Editable
                                        type="text"
                                        label="Phone Number 1"
                                        :input-value="form.phone_number_1"
                                        @update:value="form.phone_number_1 = $event"
                                        :error="form.errors.phone_number_1"
                                        required/>
                                </div>
                                <div>
                                    <Editable
                                        type="text"
                                        label="Phone Number 2"
                                        :input-value="form.phone_number_2"
                                        @update:value="form.phone_number_2 = $event"
                                        :error="form.errors.phone_number_2"
                                    />
                                </div>
                            </div>
                            <div class="lg:flex gap-2">
                                <div>
                                    <Editable
                                        type="text"
                                        label="Email Address"
                                        :input-value="form.email"
                                        @update:value="form.email = $event"
                                        :error="form.errors.email"
                                        required/>
                                </div>
                                <div>
                                    <Editable
                                        type="text"
                                        label="ID No"
                                        :input-value="form.document_id"
                                        @update:value="form.document_id = $event"
                                        :error="form.errors.document_id"
                                        required/>
                                </div>
                            </div>
                            <div class="lg:flex gap-10">
                                <div>
                                    <Editable
                                        type="text"
                                        label="Passport No"
                                        :input-value="form.document2_id"
                                        @update:value="form.document2_id = $event"
                                        :error="form.errors.document2_id"
                                        required/>
                                </div>
                                <!------------Radio------------>
                                <div>
                                    <p :class="labelClass">Tenant Type</p>
                                    <div class="md:flex md:space-x-6 mt-4">
                                        <div v-for="tenantType in tenantTypes" :key="tenantType.id"
                                             class="flex items-center">
                                            <input
                                                type="radio"
                                                :value="tenantType.id"
                                                id="tenant_type_id"
                                                v-model="form.tenant_type_id"
                                                class="text-blue-600 focus:ring-blue-500"
                                            />
                                            <label :for="tenantType.id"
                                                   class="ml-2 text-sm text-gray-600">{{ tenantType.name }}</label>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.tenant_type_id" v-text="form.errors.tenant_type_id"
                                         class="text-red-500 text-xs mt-1"></div>
                                </div>
                            </div>
                            <div>
                                <Editable
                                    type="text"
                                    label="Address"
                                    :input-value="form.address"
                                    @update:value="form.address = $event"
                                    :error="form.errors.address"
                                    required/>
                            </div>
                            <div class="flex gap-2">
                                <div>
                                    <Editable
                                        type="text"
                                        label="City"
                                        :input-value="form.city"
                                        @update:value="form.city = $event"
                                        :error="form.errors.city"
                                        required/>
                                </div>
                                <div>
                                    <Editable
                                        type="text"
                                        label="Zip"
                                        :input-value="form.zip"
                                        @update:value="form.zip = $event"
                                        :error="form.errors.zip"
                                        required/>
                                </div>
                            </div>
                            <label for="State" class="labelClass">
                                State
                            </label>
                            <Multiselect
                                v-model="selectedState"
                                :options="states"
                                :searchable="true"
                                placeholder="Select State..."
                                label="name"
                                track-by="id"
                                id="state_id"
                                :multiple="false"
                            />
                            <div v-if="form.errors.state_id" v-text="form.errors.state_id"
                                 class="text-red-500 text-xs mt-1"></div>
                            <div class="w-full">
                                <Editable
                                    type="textarea"
                                    label="Remarks"
                                    :input-value="form.remarks"
                                    @update:value="form.remarks = $event"
                                    :error="form.errors.remarks"
                                />
                            </div>
                        </div>

                        <!--Upload attachments-->
                        <div class="space-y-2 lg:pt-20">
                            <h2 class="ml-4 text-sm font-bold">File Attachments</h2>
                            <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                                <div
                                    class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-20 py-10">
                                    <div class="text-center ">
                                        <PhotographIcon class="mx-auto h-14 w-14 text-gray-300"/>
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
                    <div class="p-8 flex justify-around md:justify-start gap-2 bg-gray-50">
                        <div>
                            <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                                           class="px-8 py-2.5">
                                Save
                            </LoadingButton>
                        </div>
                        <div>
                            <SecondaryButton @click="showTenantList">
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
import AppModal from "@/Components/AppModal.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Editable from "@/Components/Editable.vue";
import {useForm, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';

let props = defineProps({
    tenant: Object,
    states: Object,
    tenantTypes: Object,
})

const modalActive = ref(true)
const isLoading = ref(false);
const selectedState = ref([]);

let form = useForm({
    'id': props.tenant ? props.tenant.id : '',
    'first_name': props.tenant ? props.tenant.first_name : '',
    'last_name': props.tenant ? props.tenant.last_name : '',
    'tenant_type_id': props.tenant ? props.tenant.tenant_type_id : '',
    'phone_number_1': props.tenant ? props.tenant.phone_number_1 : '',
    'phone_number_2': props.tenant ? props.tenant.phone_number_2 : '',
    'email': props.tenant ? props.tenant.email : '',
    'address': props.tenant ? props.tenant.email : '',
    'city': props.tenant ? props.tenant.city : '',
    'state_id': props.tenant ? props.tenant.state_id : '',
    'zip': props.tenant ? props.tenant.zip : '',
    'document_id': props.tenant ? props.tenant.document_id : '',
    'document2_id': props.tenant ? props.tenant.document2_id : '',
    'profile_photo_path': props.tenant ? props.tenant.profile_photo_path : '',
    'remarks': props.tenant ? props.tenant.remarks : '',
    'image': props.tenant ? props.tenant.image : '',
    'attachment_file_name': props.tenant ? props.tenant.tenant_attachment_files : [],
    'attachment_file': props.tenant ? props.tenant.attachment_file : '',
    'attachmentFiles': props.tenant ? props.tenant.attachmentFiles : '',
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
    form.post(route('tenant.store'), {
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

const showTenantList = () => {
    router.get(route('tenant.index'))
}

selectedState.value = props.states.find(e => e.id === form.state_id)
watch(selectedState, (newState) => {
    form.state_id = newState ? newState.id : null;
});

const labelClass = 'block tracking-wide text-gray-700 text-xs font-bold mb-2'
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
