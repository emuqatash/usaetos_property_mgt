<template>
    <form @submit.prevent="handleSubmit" class="flex flex-col md:w-6/12 mx-auto p-8">
        <div>
            <div class="flex justify-between">
                <h2 class="md:text-2xl font-bold leading-7 text-gray-900">Specifications</h2>
                <XIcon class="flex bg-white text-black h-5 w-5 cursor-pointer" @click="showJob"/>
            </div>
            <p class="mb-10 md:mb-14 pb-3 max-w-2xl text-sm leading-6 text-gray-600 border-b border-gray-200">
                Get started by filling in the information below to add your specifications.
            </p>
            <div class="space-y-10">
                <div class="space-y-7">
                    <h2 :class="divClass"> Roof</h2>
                    <div class="md:flex gap-2">
                        <div class="flex-1">
                            <label :class="labelClass"> Manufacturer</label>
                            <Multiselect
                                v-model="form.manufacturer"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Manufacturer"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Product</label>
                            <Multiselect
                                v-model="form.product"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Manufacturer"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Color</label>
                            <Multiselect
                                v-model="form.roof_color"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Manufacturer"
                                :multiple="false"
                            />
                        </div>
                    </div>

                    <div class="md:flex  gap-2 items-end">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.hip_cable" title="Hip / Gable" option1="Hip"
                                               option2="Gable"/>
                        </div>
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.cornice_strip" title="Cornice Strip" option1="Yes"
                                               option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Cornice Return</label>
                            <Multiselect
                                v-model="form.cornice_return"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Manufacturer"
                                :multiple="false"
                            />
                        </div>
                    </div>

                    <div class="md:flex  gap-2 items-end">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.soffit" title="Soffit" option1="Yes" option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Roof Layers</label>
                            <Multiselect
                                v-model="form.roof_layers"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Stories</label>
                            <Multiselect
                                v-model="form.stories"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>

                    <div class="md:flex  gap-2 items-end">
                        <div class="flex-1">
                            <label :class="labelClass"> Pitch</label>
                            <Multiselect
                                v-model="form.roof_pitch"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Pitch"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Felt</label>
                            <Multiselect
                                v-model="form.felt"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Valley Metal</label>
                            <Multiselect
                                v-model="form.valley_metal"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>

                    <div class="md:flex  gap-2 items-end">
                        <div class="flex-1">
                            <label :class="labelClass"> Ridge</label>
                            <Multiselect
                                v-model="form.ridge"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Ridge"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Valley</label>
                            <Multiselect
                                v-model="form.valley"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Satellite Dish</label>
                            <Multiselect
                                v-model="form.satellite_dish"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>

                    <div class="md:flex gap-2 items-end">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.low_slope" title="Low Slope" option1="Yes" option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Pitch</label>
                            <Multiselect
                                v-model="form.slope_pitch"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Pitch"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Type</label>
                            <Multiselect
                                v-model="form.roof_type"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Type"
                                :multiple="false"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 :class="divClass">Drip Edge</h2>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.drip_edge" title="Drip Edge" option1="Yes" option2="No"/>
                        </div>
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.painted" title="Painted" option1="Yes" option2="No"/>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label :class="labelClass"> Size</label>
                            <Multiselect
                                v-model="form.drip_edge_size"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Color</label>
                            <Multiselect
                                v-model="form.drip_edge_color"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 :class="divClass">Exhaust Cap</h2>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.exhaust_cap" title="Exhaust Cap" option1="Yes"
                                               option2="No"/>
                        </div>
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.exhaust_cap_type" title="Type" option1="Yes" option2="No"/>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label :class="labelClass"> Quantity</label>
                            <Multiselect
                                v-model="form.exhaust_cap_quantity"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Size</label>
                            <Multiselect
                                v-model="form.exhaust_cap_size"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 :class="divClass">Pipe Jack</h2>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.pipe_jack" title="Pipe Jack" option1="Yes" option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Type</label>
                            <Multiselect
                                v-model="form.pipe_jack_type"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label :class="labelClass"> Size</label>
                            <Multiselect
                                v-model="form.pipe_jack_size"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Quantity</label>
                            <Multiselect
                                v-model="form.pipe_jack_quantity"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 :class="divClass">Furnace and Chimney</h2>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label :class="labelClass"> Furnace Vent</label>
                            <Multiselect
                                v-model="form.furnace_vent"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Size</label>
                            <Multiselect
                                v-model="form.furnace_chimney_size"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Quantity</label>
                            <Multiselect
                                v-model="form.furnace_chimney_quantity"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                    <div class="flex gap-2 items-end">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.chimney_flashing" title="Chimney Flashing" option1="Yes"
                                               option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Type</label>
                            <Multiselect
                                v-model="form.chimney_flashing_type"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Quantity</label>
                            <Multiselect
                                v-model="form.chimney_flashing_quantity"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                    <div class="flex gap-2 items-end">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.chimney_diverter" title="Chimney Diverter" option1="Yes"
                                               option2="No"/>
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Type</label>
                            <Multiselect
                                v-model="form.chimney_diverter_type"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                        <div class="flex-1">
                            <label :class="labelClass"> Quantity</label>
                            <Multiselect
                                v-model="form.chimney_diverter_quantity"
                                :options="jobTypes"
                                :searchable="false"
                                placeholder="Choose Number"
                                :multiple="false"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 :class="divClass">Skylight</h2>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.skylight_lens" title="Skylight Lens" option1="Yes"
                                               option2="No"/>
                        </div>
                        <div class="flex-1">
                            <ToggleButtonGroup v-model="form.skylight_diverter" title="Skylight Diverter" option1="Yes"
                                               option2="No"/>
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <h2 class="ml-4 text-sm font-bold">Comments</h2>
                    <textarea name="notes" rows="6"
                              v-model="form.comments"
                              :class="noteClass"
                              placeholder="Add your comments">
                    </textarea>
                </div>
                <!--Upload attachments-->
                <div class="space-y-7">
                    <h2 class="ml-4 text-sm font-bold">File Attachments</h2>
                    <div class="overflow-hidden rounded-lg blueGray-200 shadow p-6">
                        <div
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
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
        </div>
        <!---------------------------Buttons ---------------------->
        <div class="mt-10 flex justify-between md:justify-end gap-x-6">
            <div>
                <SecondaryButton @click="showJob">Cancel</SecondaryButton>
            </div>
            <div>
                <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                               class="px-8 py-2.5">Save
                </LoadingButton>
            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import {ref} from "vue";
import ToggleButtonGroup from "@/Components/AppComponents/ToggleButtonGroup.vue";
import {PhotographIcon, XIcon} from "@heroicons/vue/solid";

let props = defineProps({
    specification: Object,
    jobId: String,
})

const isLoading = ref(false);

let form = useForm({
    'id': props.specification ? props.specification.id : '',
    'job_id': props.specification ? props.specification.job_id : '',
    'manufacturer': props.specification ? props.specification.manufacturer : '',
    'product': props.specification ? props.specification.product : '',
    'roof_color': props.specification ? props.specification.roof_color : '',
    'hip_cable': props.specification ? props.specification.hip_cable : '',
    'cornice_strip': props.specification ? props.specification.cornice_strip : '',
    'cornice_return': props.specification ? props.specification.cornice_return : '',
    'soffit': props.specification ? props.specification.soffit : '',
    'roof_layers': props.specification ? props.specification.roof_layers : '',
    'stories': props.specification ? props.specification.stories : '',
    'roof_pitch': props.specification ? props.specification.roof_pitch : '',
    'felt': props.specification ? props.specification.felt : '',
    'valley_metal': props.specification ? props.specification.valley_metal : '',
    'ridge': props.specification ? props.specification.ridge : '',
    'valley': props.specification ? props.specification.valley : '',
    'satellite_dish': props.specification ? props.specification.satellite_dish : '',
    'low_slope': props.specification ? props.specification.low_slope : '',
    'slope_pitch': props.specification ? props.specification.slope_pitch : '',
    'roof_type': props.specification ? props.specification.roof_type : '',
    'drip_edge': props.specification ? props.specification.drip_edge : '',
    'painted': props.specification ? props.specification.painted : '',
    'drip_edge_size': props.specification ? props.specification.drip_edge_size : '',
    'drip_edge_color': props.specification ? props.specification.drip_edge_color : '',
    'exhaust_cap': props.specification ? props.specification.exhaust_cap : '',
    'exhaust_cap_type': props.specification ? props.specification.exhaust_cap_type : '',
    'exhaust_cap_quantity': props.specification ? props.specification.exhaust_cap_quantity : '',
    'exhaust_cap_size': props.specification ? props.specification.exhaust_cap_size : '',
    'pipe_jack': props.specification ? props.specification.pipe_jack : '',
    'pipe_jack_type': props.specification ? props.specification.pipe_jack_type : '',
    'pipe_jack_size': props.specification ? props.specification.pipe_jack_size : '',
    'pipe_jack_quantity': props.specification ? props.specification.pipe_jack_quantity : '',
    'furnace_vent': props.specification ? props.specification.furnace_vent : '',
    'furnace_chimney_size': props.specification ? props.specification.furnace_chimney_size : '',
    'furnace_chimney_quantity': props.specification ? props.specification.furnace_chimney_quantity : '',
    'chimney_flashing': props.specification ? props.specification.chimney_flashing : '',
    'chimney_flashing_type': props.specification ? props.specification.chimney_flashing_type : '',
    'chimney_flashing_quantity': props.specification ? props.specification.chimney_flashing_quantity : '',
    'chimney_diverter': props.specification ? props.specification.chimney_diverter : '',
    'chimney_diverter_type': props.specification ? props.specification.chimney_diverter_type : '',
    'chimney_diverter_quantity': props.specification ? props.specification.chimney_diverter_quantity : '',
    'skylight_lens': props.specification ? props.specification.skylight_lens : '',
    'skylight_diverter': props.specification ? props.specification.skylight_diverter : '',
    'comments': props.specification ? props.specification.comments : '',
    'attachment_file_name': props.specification ? props.specification.specification_attachment_files : [],
    'attachment_file': props.specification ? props.specification.attachment_file : '',
    'attachmentFiles': props.specification ? props.specification.attachmentFiles : '',
})

const showJob = () => {
    form.get(route('jobs.show', {job: props.jobId}))
}

// handle upload attachment files
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

const attachmentFileList = ref([])
attachmentFileList.value = form?.attachment_file_name
const attachmentFileModel = ref([])

const getFileURL = (url) => {
    return url.startsWith('blob')? url : `/storage/${url.slice(7)}`
}

const inputAttachmentFile = () => {
    form.attachmentFiles = attachmentFileModel.value.map(file => file.file)
    for (let i = 0; i < attachmentFileModel.value.length;i++){
        if(!attachmentFileList.value.find(file=> file.id ===attachmentFileModel.value[i].id)){
            const file =attachmentFileModel.value[i];
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
    form.delete(route('specification-attachment-files.destroy', attachmentFileId), {
        preserveScroll: true,
    })
}

let handleSubmit = () => {
    form.job_id = props.jobId
    form.post(route('specifications.store'))
}

// // For style and design
const labelClass = ref('labelClass');
const divClass = ref('pb-1 mb-8 md:text-lg font-bold leading-7 text-gray-900 border-b border-gray-200');
const noteClass = ref(`block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset`);
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')

// // List of values
const jobTypes = ref(['Roof Replacement', 'Roof Repair', 'Other'])

</script>
<style>
.file-uploads.file-uploads-html4 input,
.file-uploads.file-uploads-html5 label {
    cursor: pointer;
}
</style>
