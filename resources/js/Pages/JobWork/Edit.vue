<template>
    <form @submit.prevent="handleSubmit">
        <div class="sm:space-y-16 p-10 lg:pl-72 lg:pr-72">
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="md:text-2xl font-bold leading-7 text-gray-900">Update Job</h2>
                    <XIcon class="flex bg-white text-black  h-6 w-6 ml-4 cursor-pointer" @click="showJob()"/>
                </div>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Get started by filling in the information
                    below to create your job.</p>
                <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y">
                    <h2 class="mt-10 md:text-lg font-bold leading-7 text-gray-900">Job information</h2>

                    <div :class="divClass">
                        <label :class="labelClass">Customer</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div :class="divInputClass">
                                <input
                                    v-model="selectedContactName"
                                    :class="inputClass"
                                    placeholder="Choose customer"
                                    style="padding-right: 30px;"
                                    @click="showAppContacts"
                                >
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1">
                                    <SelectorIcon class="h-5 w-5 text-gray-400"/></span>
                            </div>
                            <div v-if="form.errors.contact_id" v-text="form.errors.contact_id"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label for="salesman" :class="labelClass">Salesman</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300
                             focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <Multiselect
                                    v-model="selectUser"
                                    :options="salesmen"
                                    :searchable="true"
                                    placeholder="No Assignees"
                                    label="name"
                                    track-by="id"
                                    id="salesman_ids"
                                    :multiple="true"
                                    style="padding-left: 30px; padding-right: 30px;"
                                />
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                <PlusCircleIcon class="h-5 w-5 text-gray-400"/></span>
                            </div>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label for="jobNumber" :class="labelClass">Job Number</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div :class="divInputClass">
                                <input v-model="form.job_number"
                                       :class="inputClass" aria-haspopup="listbox" aria-expanded="true"
                                       aria-labelledby="listbox-label" placeholder="Job #" style="padding-right: 30px;">
                            </div>
                            <div v-if="form.errors.job_number" v-text="form.errors.job_number"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label for="jobLocation" :class="labelClass">Job Location</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300
                             focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-xl">
                                <input v-model="form.job_location"
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
                            <div v-if="form.errors.job_location" v-text="form.errors.job_location"
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label for="job_type" :class="labelClass">Job Type</label>
                        <fieldset class="mt-4">
                            <div class="md:flex md:justify-between">
                                <div v-for="jobType in jobTypes"
                                     class="flex items-center">
                                    <input
                                        type="radio"
                                        :value="jobType"
                                        id="jobType"
                                        v-model="form.job_type"
                                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-indigo-600"
                                    />
                                    <label :for="jobType"
                                           class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ jobType }}
                                    </label>
                                </div>
                            </div>
                            <div v-if="form.errors.job_type" v-text="form.errors.job_type"
                                 class="text-red-500 text-xs mt-1"></div>
                        </fieldset>
                    </div>
                    <div :class="divClass">
                        <label for="job_type" :class="labelClass">Roof Type</label>
                        <fieldset class="mt-4">
                            <div class="md:flex md:justify-between">
                                <div v-for="roofType in roofTypes"
                                     class="flex items-center">
                                    <input
                                        type="radio"
                                        :value="roofType"
                                        id="jobType"
                                        v-model="form.roof_type"
                                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-indigo-600"
                                    />
                                    <label :for="roofType"
                                           class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ roofType }}
                                    </label>
                                </div>
                            </div>
                            <div v-if="form.errors.job_type" v-text="form.errors.job_type"
                                 class="text-red-500 text-xs mt-1"></div>
                        </fieldset>
                    </div>
                    <div :class="divClass">
                        <label for="InsuranceAgent" :class="labelClass">
                            Insurance Agent/Adjuster
                        </label>
                        <Multiselect
                            v-model="selectInsuranceAgent"
                            :options="insuranceAgentList"
                            :searchable="true"
                            placeholder="Choose Insurance Agent"
                            label="agent_name"
                            track-by="id"
                            id="insurance_agents_id"
                            :multiple="false"
                        />
                        <div v-if="form.errors.insurance_agents_id" v-text="form.errors.insurance_agents_id"
                             class="text-red-500 text-xs mt-1"></div>
                    </div>
                    <div :class="divClass">
                        <label for="insuranceClaimNumber" :class="labelClass">Insurance Claim Number</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div :class="divInputClass">
                                <input v-model="form.insurance_claim_number"
                                       :class="inputClass" aria-haspopup="listbox" aria-expanded="true"
                                       aria-labelledby="listbox-label" placeholder="Insurance Claim #"
                                       style="padding-right: 30px;">
                            </div>
                        </div>
                    </div>
                    <div :class="divClass">
                        <label for="about"
                               :class="labelClass">Notes</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <textarea v-model="form.notes" name="notes" rows="3"
                                      :class="noteClass"
                                      placeholder="Notes">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-between md:justify-end gap-x-6">
                <div>
                    <SecondaryButton @click="showJob">
                        Cancel
                    </SecondaryButton>
                </div>
                <div>
                    <LoadingButton type="submit" :isLoading="isLoading" :disabled="form.processing"
                                   class="px-8 py-2.5">
                        Update
                    </LoadingButton>
                </div>
            </div>
        </div>
    </form>
    <AppContacts v-if="appContactsActive" :filters="form" :contact="contactList" @cancel="handleCloseModel"
                 @selectedContact="handleSelectedContact"/>

</template>

<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {XIcon, SelectorIcon, PlusCircleIcon, LocationMarkerIcon} from "@heroicons/vue/solid";
import {ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import AppContacts from "@/Components/AppComponents/AppContacts.vue";
import {debounce} from "lodash";


let props = defineProps({
    job: Object,
    salesmen: Object,
    contactList: Object,
    insuranceAgentList: Array,
    selectedSalesmen: Object,
})

let form = useForm(props.job)

const appContactsActive = ref(false)
const search = ref([])
const contactList = ref(props.contactList)
const selectUser = ref([])
const selectInsuranceAgent = ref(props.job.insurance_agent)
const selectedContactName = ref('');

selectedContactName.value = form.contact.first_name + ' ' + form.contact.last_name
selectUser.value = props?.selectedSalesmen

watch([selectInsuranceAgent, selectUser], ([newInsuranceAgent, newUsers]) => {
    form.insurance_agents_id = newInsuranceAgent ? newInsuranceAgent.id : null;
    form.salesman_ids = newUsers.map(user => user.id);
})

const isLoading = ref(false);
const showJob = () => {
    router.get(route('jobworks.show', props.job.id))
}

const showAppContacts = () => {
    appContactsActive.value = true
}
const handleCloseModel = () => {
    appContactsActive.value = false
}

const handleSelectedContact = (selectedContact) => {
    form.contact_id = selectedContact.id;
    selectedContactName.value = `${selectedContact.first_name} ${selectedContact.last_name}`;
    appContactsActive.value = false;
}

let handleSubmit = () => {
    form.put(route('jobworks.update', form.id) ,{
        onStart: () => {
            isLoading.value = true
        },
        onError: () => {
            isLoading.value = false
        },
    })
}

// Google maps API Autocomplete address
const addresses = ref([]);
const fetchAddressSuggestions = debounce(async () => {
    if (form.job_location.length > 2) {
        try {
            const response = await axios.get('/api/google-places/autocomplete', {
                params: {input: form.job_location}
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
    form.job_location = address.description;
    addresses.value = [];
}

// For style and design
const labelClass = ref('labelClass');
const inputClass = ref(`relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left
focus:outline-none focus:ring-2 focus:ring-indigo-600
sm:text-sm sm:leading-6`);
const divClass = ref('sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6');
const divInputClass = ref(`relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2
focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md`);
const noteClass = ref(`block w-full max-w-2xl rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset`);

// List of values
const jobTypes = ref(['Roof Replacement', 'Roof Repair', 'Other'])
const roofTypes = ref(['Wood', 'Composite', 'Flat', 'Metal', 'Other'])

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
