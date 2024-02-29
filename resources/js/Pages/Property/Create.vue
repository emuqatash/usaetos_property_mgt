<template>
    <form @submit.prevent="handleSubmit">
        <div class="space-y-8 p-4 lg:pl-60 lg:pr-60">
            <div>
                <div class="mt-10 space-y-6 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y">
                    <h2 class="mt-10 md:text-lg font-bold text-gray-900 pb-2">Enter New Property information</h2>
                    <!--1raw-->
                    <div class="lg:flex pt-0 lg:pt-6 space-x-0 lg:space-x-6 space-y-2 lg:space-y-0">
                        <div :class="`${divClass} flex-grow`">
                            <Editable
                                label="Property No"
                                :input-value="form.property_no"
                                @update:value="form.property_no = $event"
                                :error="form.errors.property_no"
                                required/>
                        </div>
                        <div :class="`${divClass} flex-grow `">
                            <Editable
                                label="Property Name"
                                :input-value="form.property_name"
                                @update:value="form.property_name = $event"
                                :error="form.errors.property_name"
                                required/>
                        </div>
                    </div>

                    <!--2raw-->
                    <div class="lg:flex space-x-0 lg:space-x-6 space-y-2 lg:space-y-0">
                        <div :class="`${divClass} flex-grow`">
                            <Editable
                                label="Owner"
                                :input-value="form.owner"
                                @update:value="form.owner = $event"
                                :error="form.errors.owner"
                                required/>
                        </div>
                        <div :class="divClass">
                            <Editable
                                type="number"
                                label="Ownership Rate %"
                                :input-value="form.ownership_rate"
                                @update:value="form.ownership_rate = $event"
                                :error="form.errors.ownership_rate"
                                required/>
                        </div>
                    </div>

                    <!--3raw-->
                    <div class="lg:flex space-x-0 lg:space-x-6 space-y-2 lg:space-y-0">
                        <div :class="`${divClass} flex-grow `">
                            <Editable
                                label="Address"
                                :input-value="form.address"
                                @update:value="form.address = $event"
                                :error="form.errors.address"
                                required/>
                        </div>
                        <div :class="divClass">
                            <Editable
                                label="City"
                                :input-value="form.city"
                                @update:value="form.city = $event"
                                :error="form.errors.city"
                                required/>
                        </div>
                        <div :class="`${divClass} flex-grow`">
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
                                 class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <!--4raw-->
                    <div class="lg:flex space-x-0 lg:space-x-6 space-y-2 lg:space-y-0">
                        <div :class="divClass">
                            <Editable
                                label="Zip Code"
                                :input-value="form.zip"
                                @update:value="form.zip = $event"
                                :error="form.errors.zip"
                                required/>
                        </div>
                        <div :class="`${divClass} flex-grow`">
                            <Editable
                                type="date"
                                label="Date Of Purchase"
                                :input-value="form.date_of_purchase"
                                @update:value="form.date_of_purchase = $event"
                                :error="form.errors.date_of_purchase"
                                required/>
                        </div>
                        <div :class="divClass">
                            <Editable
                                label="Area Size"
                                :input-value="form.area_size"
                                @update:value="form.area_size = $event"
                                :error="form.errors.area_size"
                                required/>
                        </div>
                        <div :class="divClass">
                            <Editable
                                type="number"
                                label="Number of bedrooms"
                                :input-value="form.number_of_bedrooms"
                                @update:value="form.number_of_bedrooms = $event"
                                :error="form.errors.number_of_bedrooms"
                                required/>
                        </div>
                    </div>

                    <!--5raw-->
                    <div class="lg:flex space-x-0 lg:space-x-6 space-y-2 lg:space-y-0">
                        <div :class="`${divClass} flex-grow`">
                            <Editable
                                type="number"
                                label="Cost"
                                :input-value="form.cost"
                                @update:value="form.cost = $event"
                                :error="form.errors.cost"
                                required/>
                        </div>
                        <div :class="`${divClass} flex-grow`">
                            <Editable
                                type="number"
                                label="Payments Left"
                                :input-value="form.payments_left"
                                @update:value="form.payments_left = $event"
                                :error="form.errors.payments_left"
                                required/>
                        </div>
                        <div :class="`${divClass} flex-grow`">
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
            </div>

            <div class="flex items-center justify-between md:justify-end gap-x-6">
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
import {ref, watch} from "vue";
import Editable from "@/Components/Editable.vue";

let props = defineProps({
    property: Object,
    states: Object,
})

const isLoading = ref(false);
const selectedState = ref([]);

let form = useForm({
    'id': props.property ? props.property.id : '',
    'property_no': props.property ? props.property.property_no : '',
    'property_name': props.property ? props.property.property_name : '',
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
    'property_status': props.states ? props.states.property_status : '',
})

selectedState.value = props.states.find(e => e.id === form.state_id)
watch(selectedState, (newState) => {
    form.state_id = newState ? newState.id : null;
});
const showPropertyList = () => {
    form.get(route('property.index'))
}

let handleSubmit = () => {
    form.post(route('property.store'))
}

// // For style and design
const labelClass = ref('labelClass');
const divClass = ref('sm:grid sm:grid-cols-1 sm:items-start sm:py-6');
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

