<template>
    <form @submit.prevent="handleSubmit">
        <div class="space-y-8 p-4 lg:w-10/12 mx-auto">
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900" v-if="!form.id">Create Property</h2>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900" v-if="form.id">Update Property</h2>
                    <XIcon class="flex bg-white text-black  h-6 w-6 lg:ml-4 cursor-pointer" @click="backToList()"/>
                </div>
                <div class="lg:mt-4 pb-4 sm:space-y-0 sm:divide-y">
                    <div class="lg:flex lg:gap-20 lg:pb-4">
                        <h2 class="mt-10 md:text-lg font-bold text-gray-900 pb-2">Deactivate Property to appear under Inactive List</h2>
                        <Toggle v-model="form.active"  class="mt-10"/>
                    </div>
                </div>
                    <!--1raw-->
                    <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                        <div class="divClass lg:w-2/12">
                            <Editable
                                label="Property No"
                                :input-value="form.property_no"
                                @update:value="form.property_no = $event"
                                :error="form.errors.property_no"
                                required/>
                        </div>
                        <div class="divClass lg:w-5/12">
                            <Editable
                                label="Property Name"
                                :input-value="form.name"
                                @update:value="form.name = $event"
                                :error="form.errors.name"
                                required/>
                        </div>
                        <div class="divClass lg:w-3/12">
                            <label class="labelClass">Status</label>
                            <MultiselectCustom v-model="form.property_status" :options="propertyStatus"/>
                        </div>
                        <div class="divClass lg:w-2/12">
                            <label class="labelClass">Property type</label>
                            <MultiselectCustom v-model="form.property_type" :options="propertyTypes"/>
                            <div v-if="form.errors.property_type" v-text="form.errors.property_type" :class="errorClass"></div>
                        </div>
                    </div>

                    <!--2raw-->
                    <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                        <div class="divClass lg:w-7/12">
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <label class="labelClass">Address</label>
                            <div class="relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300
                             focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 ">
                                <input v-model="form.address"
                                       @input="fetchAddressSuggestions"
                                       :class="inputClass"
                                       placeholder="Enter Location"
                                       style="padding-left: 30px; padding-right: 30px;">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                    <LocationMarkerIcon class="h-5 w-5 text-gray-400"/></span>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1">
                                <SelectorIcon class="h-5 w-5 text-gray-400"/></span>
                            </div>
                            <ul v-if="addresses.length" class="absolute z-10 w-full bg-white p-4
                            rounded-md shadow-lg cursor-pointer max-w-xs sm:max-w-xl">
                                <li v-for="address in addresses" :key="address.place_id" @click="selectAddress(address)"
                                    class="hover:bg-blue-400">
                                    {{ address.description }}
                                </li>
                            </ul>
                            <div v-if="form.errors.address" v-text="form.errors.address"
                                 :class="errorClass"></div>
                            </div>
                        </div>
                        <div class="divClass lg:w-2/12">
                            <Editable
                                label="City"
                                :input-value="form.city"
                                @update:value="form.city = $event"
                                :error="form.errors.city"
                                required/>
                        </div>
                        <div class="divClass lg:w-3/12">
                            <label for="State" class="labelClass">
                                State
                            </label>
                            <div>
                                <Multiselect
                                    v-model="selectedState"
                                    :options="states"
                                    :searchable="true"
                                    placeholder="Select State..."
                                    label="name"
                                    track-by="id"
                                    id="state_id"
                                    :multiple="false"
                                    class="border-gray-800"
                                />
                            </div>
                            <div v-if="form.errors.state_id" v-text="form.errors.state_id"
                                 :class="errorClass"></div>
                        </div>
                    </div>

                    <!--3raw-->
                     <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                        <div class="divClass lg:w-7/12">
                            <Editable
                                label="Owner"
                                :input-value="form.owner"
                                @update:value="form.owner = $event"
                                :error="form.errors.owner"
                                required/>
                        </div>
                        <div class="divClass w-2/12 xl::w-1/12" >
                           <Editable
                                type="number"
                                label="Ownership Rate %"
                                :input-value="form.ownership_rate"
                                @update:value="form.ownership_rate = $event"
                                :error="form.errors.ownership_rate"
                                required/>
                        </div>
                         <div class="divClass lg:w-2/12">
                             <Editable
                                 label="Zip Code"
                                 :input-value="form.zip"
                                 @update:value="form.zip = $event"
                                 :error="form.errors.zip"
                                 required/>
                         </div>
                         <div class="divClass lg:w-2/12">
                             <Editable
                                 type="date"
                                 label="Date Of Purchase"
                                 :input-value="form.date_of_purchase"
                                 @update:value="form.date_of_purchase = $event"
                                 :error="form.errors.date_of_purchase"
                                 required/>
                         </div>
                    </div>

                    <!--4raw-->
                    <div class="lg:flex mt-6 lg:gap-2 lg:pb-4 border-b border-gray-900/10 space-y-6 lg:space-y-0">
                        <div class="divClass lg:w-2/12">
                           <Editable
                                label="Area Size"
                                :input-value="form.area_size"
                                @update:value="form.area_size = $event"
                                :error="form.errors.area_size"
                                required/>
                        </div>
                        <div class="divClass lg:w-2/12">
                           <Editable
                                type="number"
                                label="Number of bedrooms"
                                :input-value="form.number_of_bedrooms"
                                @update:value="form.number_of_bedrooms = $event"
                                :error="form.errors.number_of_bedrooms"
                                required/>
                        </div>
                        <div class="divClass lg:w-3/12">
                            <Editable
                                type="text"
                                label="Cost"
                                :input-value="form.cost"
                                @update:value="form.cost = $event"
                                :error="form.errors.cost"
                                required/>
                        </div>
                        <div class="divClass lg:w-2/12">
                            <Editable
                                type="number"
                                label="Payments Left"
                                :input-value="form.payments_left"
                                @update:value="form.payments_left = $event"
                                :error="form.errors.payments_left"
                                required/>
                        </div>
                        <div class="divClass lg:w-3/12">
                            <Editable
                                type="date"
                                label="Hand Over"
                                :input-value="form.handover_date"
                                @update:value="form.handover_date = $event"
                                :error="form.errors.handover_date"
                                required/>
                        </div>
                    </div>

            </div>

            <div class="flex items-center justify-between md:justify-end gap-x-6">
                <div>
                    <SecondaryButton @click="backToList">
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
import {router, useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import {ref, watch} from "vue";
import Editable from "@/Components/Editable.vue";
import MultiselectCustom from "@/Components/MultiselectCustom.vue";
import {LocationMarkerIcon, SelectorIcon, XIcon} from "@heroicons/vue/solid";
import Toggle from "@/Components/Toggle.vue";
import {debounce} from "lodash";
import axios from 'axios';

let props = defineProps({
    property: Object,
    states: Object,
})

let form = useForm({
    'id': props.property ? props.property.id : '',
    'property_no': props.property ? props.property.property_no : '',

    'name': props.property ? props.property.name : '',
    'owner': props.property ? props.property.owner : '',
    'ownership_rate': props.property ? props.property.ownership_rate : '',
    'address': props.property ? props.property.address : '',
    'city': props.property ? props.property.city : '',
    'state_id': props.property ? props.property.state_id : '',
    'zip': props.property ? props.property.zip : '',
    'date_of_purchase': props.property ? props.property.date_of_purchase : '',
    'area_size': props.property ? props.property.area_size : '',
    'number_of_bedrooms': props.property ? props.property.number_of_bedrooms : '',
    'cost': props.property ? props.property.cost : '',
    'payments_left': props.property ? props.property.payments_left : '',
    'handover_date': props.property ? props.property.handover_date : '',
    'active': props.property ? !!props.property.active : true,
    'property_status': props.property && props.property.property_status ? props.property.property_status : 'Vacant',
    'property_type': props.property && props.property.property_type ? props.property.property_type : '',
})


const isLoading = ref(false);

const selectedState = ref([]);
selectedState.value = props.states.find(e => e.id === form.state_id)

watch(selectedState, (newState) => {
    form.state_id = newState ? newState.id : null;
});
const backToList = () => {
    // form.get(route('property.index' ))
    router.get(route('property.index'))
}

let handleSubmit = () => {
    form.post(route('property.store'))
}

/////////////////////Google maps Rest API Autocomplete address////////////////////
const addresses = ref([]);
const fetchAddressSuggestions = debounce(async () => {
    if (form.address.length > 2) {
        try {
            const response = await axios.get('/api/google-places/autocomplete', {
                params: {input: form.address}
            });
            addresses.value = response.data;
        } catch (error) {
            console.error('Error fetching address suggestions:', error);
        }
    } else {
        addresses.value = [];
    }
}, 200)

const selectAddress = (address) => {
    form.address = address.description;
    addresses.value = [];
}
////////////////////////////////////////////////////////////////////////////////

// // For style and design
const inputClass = ref('appearance-none block w-full text-gray-700 border border-gray-200 ' +
    'rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500',);
const errorClass = ref('text-red-500 text-xs mt-1');


// // List of values
const propertyStatus = ref(['Vacant', 'Occupied', 'Rented', 'Under Maintenance'])
const propertyTypes = ref(['Apartment', 'Commercial', 'Duplex', 'House', 'Mixed-Use', 'Other'])


</script>
<style>.multiselect__single, .multiselect__input, .multiselect__tags {
    min-height: 28px; /* adjust according to your need */
}</style>

