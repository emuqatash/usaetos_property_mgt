<template>
    <AuthenticatedLayout :sub-menu="'SETTINGS'">
        <!-- Modal -->
        <AppModal :modalActive="modalActive">
            <form @submit.prevent="validateRequest">
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <div class="lg:flex">
                    <div class="p-7 relative border-b border-gray-100 space-y-4">
                        <p class=" text-xl font-semibold mb-6">Update Contact</p>
                        <div class="flex gap-2">
                            <div>
                                <Editable
                                    type="text"
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
                        <div class="flex gap-2">
                            <div>
                                <Editable
                                    type="text"
                                    label="Phone Number"
                                    :input-value="form.phone_number"
                                    @update:value="form.phone_number = $event"
                                    :error="form.errors.phone_number"
                                    required/>
                            </div>
                            <div>
                                <Editable
                                    type="text"
                                    label="Email Address"
                                    :input-value="form.email"
                                    @update:value="form.email = $event"
                                    :error="form.errors.email"
                                    required/>
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
                        <div>
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
                                :multiple="false"/>
                            <div v-if="form.errors.state_id" v-text="form.errors.state_id"
                                 class="text-red-500 text-xs mt-1"></div>
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
                        <!-- Radio-->
                        <div class=" mb-4">
                            <p class="mt-4 text-md">Contact Type</p>
                            <div class="md:flex md:space-x-6 mt-4">
                                <div v-for="contactType in contactTypes" :key="contactType.id"
                                     class="flex items-center">
                                    <input
                                        type="radio"
                                        :value="contactType.id"
                                        id="contact_type_id"
                                        v-model="form.contact_type_id"
                                        class="text-blue-600 focus:ring-blue-500"/>
                                    <label :for="contactType.id"
                                           class="ml-2 text-sm text-gray-600">{{ contactType.name }}</label>
                                </div>
                            </div>
                            <div v-if="form.errors.contact_type_id" v-text="form.errors.contact_type_id"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <!--photo-->
                    <div class="p-16 flex flex-col place-items-center ">
                        <div>
                            <UserIcon v-if="!url" class="rounded-full bg-gray-400 text-gray-50 p-2 w-32 h-32"/>
                            <img v-if="url" :src="url" alt="Preview" class="rounded-full p-2 w-36 h-36"/>
                        </div>
                        <div class="p-8">
                            <AppButton class="px-8 py-2.5" onclick="document.getElementById('getFile').click()">
                                Update photo
                            </AppButton>
                            <input
                                type='file'
                                name="image"
                                id="getFile"
                                style="display:none"
                                @change="onFileChange">
                        </div>
                    </div>
                </div>
                <!--Buttons-->
                <div class="p-8 flex justify-around md:justify-start gap-2 bg-gray-50">
                    <div>
                        <LoadingButton
                            type="submit"
                            :isLoading="isLoading"
                            :disabled="form.processing"
                            class="px-8 py-2.5"
                        >
                            Update
                        </LoadingButton>
                    </div>
                    <div>
                        <SecondaryButton @click="showContactList">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>
            </form>
        </AppModal>

        <!---- View On duplicate first name, last name and phone number-->
        <div>
            <Show v-if="duplicateError" :contact="form" :selectedState="selectedState" :url="url"
                  :selectedContactType="selectedContactType" @submit-form="submit" @cancel="handleCancel"/>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AppModal from "@/Components/AppModal.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Editable from "@/Components/Editable.vue";
import {useForm, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import AppButton from "@/Components/AppButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {UserIcon} from '@heroicons/vue/solid';
import LoadingButton from '@/Components/LoadingButton.vue';
import Show from '@/Pages/Contact/Show.vue';

const modalActive = ref(true)
const isLoading = ref(false);
const url = ref('');
const selectedState = ref([]);
const selectedImage = ref(null);
const duplicateError = ref(null);
const selectedContactType = ref([]);

const props = defineProps({
    contact: Object,
    states: Object,
    contactTypes: Object,
})

let form = useForm({...props.contact, 'image': ''})

let validateRequest = () => {
    form.image = selectedImage.value
    form.post(route('contacts.validateRequest'), {
        onStart: () => {
            isLoading.value = true
        },
        onError: () => {
            if (Object.keys(form.errors).length === 1 && form.errors['first_name'] === 'Duplicate first, last name and phone number') {
                selectedContactType.value = props.contactTypes.find(e => e.id === form.contact_type_id)
                duplicateError.value = true
            }
            isLoading.value = false
        },
        onSuccess: () => {
            form.clearErrors()
            form.post(route('contacts.store'))
        },
    })
}

let submit = () => {
    form.clearErrors()
    form.image = selectedImage.value
    form.post(route('contacts.store'))
}

// Multiselect
selectedState.value = props.states.find(e => e.id === form.state_id)
watch(selectedState, (newState) => {
    form.state_id = newState ? newState.id : null;
});

// image
const getImageUrl = (path) => {
    return path ? `/storage/${path}` : null;
};
url.value = getImageUrl(form.profile_photo_path)

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        selectedImage.value = file;
        url.value = URL.createObjectURL(file);
    }
};

const showContactList = () => {
    router.get(route('contacts.index'))
}

const handleCancel = () => {
    duplicateError.value = false;
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
