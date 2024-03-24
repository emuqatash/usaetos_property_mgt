<template>
<AuthenticatedLayout :sub-menu="'PROPERTYEXPENSES'">
<AppModal :modalActive="modalActive">
    <div class="w-full h-full p-6 mx-auto justify-between border-b border-gray-100 overflow-auto max-h-screen">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="space-y-6 md:space-y-2 relative border-b border-gray-100 ">
                <p class="text-xl font-semibold mb-6" v-if="!form.id">Create Property Expenses</p>
                <p class="text-xl font-semibold mb-6" v-if="form.id">Update Property Expenses</p>
            </div>
            <div>
                <!--1row-->
                <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                    <div class="lg:w-7/12">
                        <Editable
                            type="text"
                            label="Description"
                            :input-value="form.description"
                            @update:value="form.description = $event"
                            :error="form.errors.description"/>
                    </div>
                    <div class="lg:w-3/12">
                        <Editable
                            type="date"
                            label="Payment Date"
                            :input-value="form.payment_date"
                            @update:value="form.payment_date = $event"
                            :error="form.errors.payment_date" />
                    </div>
                    <div class="lg:w-2/12">
                        <Editable
                            type="number"
                            label="Payment amount"
                            :input-value="form.payment_amount"
                            @update:value="form.payment_amount = $event"
                            :error="form.errors.payment_amount" />
                    </div>
                </div>


                <!--2row-->
                <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                    <div class="lg:w-4/12">
                        <label class="labelClass">
                            Category
                        </label>
                        <Multiselect
                            v-model="selectedCategory"
                            :options="propertyExpenseCategories"
                            :searchable="true"
                            placeholder="Select Category..."
                            :customLabel="categoryCustomLabel"
                            track-by="id"
                            id="property_expense_category_id"
                            :multiple="false"
                        />
                        <div v-if="form.errors.property_expense_category_id" v-text="form.errors.property_expense_category_id"
                             class="text-red-500 text-xs mt-1"></div>
                    </div>
                    <div class="lg:w-4/12">
                        <Editable
                            type="text"
                            label="Receipt id"
                            :input-value="form.receipt_id"
                            @update:value="form.receipt_id = $event"
                            :error="form.errors.receipt_id" />
                    </div>
                    <div class="lg:w-4/12">
                        <Editable
                            type="text"
                            label="Supplier"
                            :input-value="form.supplier"
                            @update:value="form.supplier = $event"
                            :error="form.errors.supplier" />
                    </div>
                </div>
            </div>
        </div>

        <!--Upload attachments-->
        <div class="space-y-2 mt-6">
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
                                    <p class="mt-4 text-md imageClass">Upload a file</p>
                                    <p class="pl-1 mt-4">or drag and drop</p>
                                </div>
                            </file-upload>
                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Buttons-->
        <div class="flex items-center justify-between md:justify-end gap-x-6 mt-6">
            <div>
                <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                               class="px-8 py-2.5">
                    Save
                </LoadingButton>
            </div>
            <!--{{ $propertyExpenseCategories}}-->
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
import {ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {PhotographIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";

let props = defineProps({
    propertyExpenses: Object,
    propertyExpenseCategories: Object,
    property_id: {
        type: [Number, String]
    }
})

const modalActive = ref(true)
const isLoading = ref(false)
const selectedCategory = ref([])

let form = useForm({
    'id': props.propertyExpenses ? props.propertyExpenses.id : '',
    'property_id': props.propertyExpenses ? props.propertyExpenses.property_id : props.property_id,

    'payment_date': props.propertyExpenses ? props.propertyExpenses.payment_date : '',
    'property_expense_category_id': props.propertyExpenses ? props.propertyExpenses.property_expense_category_id : '',
    'description': props.propertyExpenses ? props.propertyExpenses.description : '',
    'payment_amount': props.propertyExpenses ? props.propertyExpenses.payment_amount : '',
    'receipt_id': props.propertyExpenses ? props.propertyExpenses.receipt_id : '',
    'supplier': props.propertyExpenses ? props.propertyExpenses.supplier : '',

    'attachment_file_name': props.propertyExpenses ? props.propertyExpenses.property_expense_attachment_files : [],
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

const cancel = () => {
    form.get(route('property-expense.show',
        (props.propertyExpenses && props.propertyExpenses.property_id) ?
            props.propertyExpenses.property_id :  props.property_id))
}

selectedCategory.value = props.propertyExpenseCategories.find(e => e.id === form.property_expense_category_id)
watch(selectedCategory, (newState) => {
    form.property_expense_category_id = newState ? newState.id : null;
});

const categoryCustomLabel = (property) => {
    return `${property.name}`;
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
