<template>
    <form @submit.prevent="handleSubmit">
        <div class="sm:space-y-16 p-10 lg:pl-72 lg:pr-72">
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="md:text-2xl font-bold leading-7 text-gray-900">Property</h2>
                    <!-- Assuming XIcon is a component like from Heroicons -->
                    <XIcon class="flex bg-white text-black  h-6 w-6 ml-4 cursor-pointer" @click="showPropertyList()"/>
                </div>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Get started by filling in the information
                    below to create your job.</p>
                <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y">
                    <h2 class="mt-10 md:text-lg font-bold leading-7 text-gray-900">Property information</h2>
                    <div :class="divClass">
                        <label for="jobNumber" :class="labelClass">Property No</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div :class="divInputClass">
                                <input v-model="form.property_no"
                                       :class="inputClass" aria-haspopup="listbox" aria-expanded="true"
                                       aria-labelledby="listbox-label" style="padding-right: 30px;">
                            </div>
                            <div v-if="form.errors.property_no" v-text="form.errors.property_no"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <div :class="divClass">
                        <label for="jobNumber" :class="labelClass">Property Name</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div :class="divInputClass">
                                <input v-model="form.property_name"
                                       :class="inputClass" aria-haspopup="listbox" aria-expanded="true"
                                       aria-labelledby="listbox-label" style="padding-right: 30px;">
                            </div>
                            <div v-if="form.errors.property_name" v-text="form.errors.property_name"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

<!--to use other design-->

                    <!--1raw-->
                    <div class="lg:flex pt-0 lg:pt-6 space-x-0 lg:space-x-6">
                        <div :class="`${divClass} flex-grow`">
                            <label :class="labelClass">Property No</label>
                            <input v-model="form.property_no" :class="inputClass">
                            <div v-if="form.errors.property_no" v-text="form.errors.property_no"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                        <div :class="`${divClass} flex-grow `">
                            <label :class="labelClass">Property Name</label>
                            <input v-model="form.property_name" :class="inputClass">
                            <div v-if="form.errors.property_name" v-text="form.errors.property_name"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <!--2raw-->
                    <div class="lg:flex space-x-0 lg:space-x-6">
                        <div :class="`${divClass} flex-grow`">
                            <label :class="labelClass">Owner</label>
                            <input v-model="form.owner" :class="inputClass">
                            <div v-if="form.errors.owner" v-text="form.errors.owner"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                        <div :class="divClass">
                            <label :class="labelClass">Ownership Rate %</label>
                            <input v-model="form.ownership_rate" :class="inputClass">
                            <div v-if="form.errors.ownership_rate" v-text="form.errors.ownership_rate"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
<!--end other design-->

                </div>
            </div>
            <div class="mt-6 flex items-center justify-between md:justify-end gap-x-6">
                <div>
                    <SecondaryButton @click="showPropertyList">
                        Cancel
                    </SecondaryButton>
                </div>
                <div>
                    <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                                   class="px-8 py-2.5">
                        Save
                    </LoadingButton>
                </div>
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
import {LocationMarkerIcon, PhotographIcon, PlusCircleIcon, SelectorIcon, XIcon} from "@heroicons/vue/solid";
import AppContacts from "@/Components/AppComponents/AppContacts.vue";

let props = defineProps({
    property: Object,
    states: Object,
})

const isLoading = ref(false);

let form = useForm({
    'id': props.property ? props.property.id : '',
    'property_no': props.property ? props.property.property_no : '',
    'property_name': props.property ? props.property.property_name : '',
    'property_status': props.states ? props.states.property_status : '',
    'address': props.property ? props.property.address : '',
    'city': props.property ? props.property.city : '',
    'state_id': props.property ? props.property.state_id : '',
    'owner': props.property ? props.property.owner : '',
    'ownership_rate': props.property ? props.property.ownership_rate : '',
    'date_of_purchase': props.property ? props.property.date_of_purchase : '',
    'Area_size': props.property ? props.property.Area_size : '',
    'number_of_bedrooms': props.property ? props.property.number_of_bedrooms : '',
    'cost': props.property ? props.property.cost : '',
    'payments_left': props.property ? props.property.payments_left : '',
    'hand_over': props.property ? props.property.hand_over : '',
})

const showPropertyList = () => {
    form.get(route('property.index'))
}

let handleSubmit = () => {
    form.post(route('property.store'))
}

// // For style and design
const labelClass = ref('labelClass');
const divClass = ref('sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6');
const noteClass = ref(`block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset`);
const imageClass = ref('relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 ' +
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 ' +
    'hover:text-indigo-500')

const inputClass = ref(`relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left
focus:outline-none focus:ring-2 focus:ring-indigo-600
sm:text-sm sm:leading-6`);
const divInputClass = ref(`relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2
focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md`);

// // List of values


</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.file-uploads.file-uploads-html4 input,
.file-uploads.file-uploads-html5 label {
    cursor: pointer;
}
</style>
