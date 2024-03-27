<template>
<AuthenticatedLayout :sub-menu="'PROPERTYRENTS'">
<AppModal :modalActive="modalActive" width="w-full sm:max-w-2xl">
    <div class="w-full h-full p-6 mx-auto justify-between border-b border-gray-100 overflow-auto max-h-screen">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>
            <div class="space-y-6 md:space-y-2 relative mb-10">
                <p class="text-xl font-semibold mb-3" v-if="!form.id">Add Rent Payment</p>
                <p class="text-xl font-semibold mb-3" v-if="form.id">Update Rent Payment</p>
                <p class="text-sm">
                    You may adjust <span class="font-bold text-gray-700">Rent Amount, Late Fee or Grace Period</span>
                    values from Tenancy Contract, if you adjust Rent Amount or Late Fee, it will be reflected on this
                    rent payment only.
                </p>
            </div>
                <!--1row-->
            <div class="lg:flex gap-2 space-y-4 md:space-y-0">
                <div class="lg:w-2/12">
                    <Editable
                        type="text"
                        label="Current Late Fee"
                        :disabled="disabled"
                        customStyle="bg-gray-200"
                        :input-value="props.currentLateFee"
                        @update:value="props.currentLateFee = $event"/>
                </div>
            </div>
            <!--2row-->
                <div class="lg:flex gap-2 space-y-4 md:space-y-0 mt-8">
                    <div class="lg:w-5/12">
                        <Editable
                            type="date"
                            label="Payment Date"
                            :input-value="form.payment_date"
                            @update:value="form.payment_date = $event"
                            :error="form.errors.payment_date"/>
                    </div>
                    <div class="lg:w-3/12">
                        <Editable
                            type="text"
                            label="Rent Amount"
                            :input-value="form.payment_amount"
                            @update:value="form.payment_amount = $event"
                            :error="form.errors.payment_amount"/>
                    </div>
                    <div class="lg:w-2/12">
                        <Editable
                            type="text"
                            label="Late Fee"
                            :input-value="form.late_fee"
                            @update:value="form.late_fee = $event"
                            :error="form.errors.late_fee"/>
                    </div>
                    <div class="lg:w-2/12">
                        <Editable
                            type="text"
                            label="Grace Period"
                            :disabled="disabled"
                            customStyle="bg-gray-200"
                            :input-value="form.grace_period"
                            @update:value="form.grace_period = $event"
                            :error="form.errors.grace_period"/>
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
import {router, useForm} from "@inertiajs/vue3";
import {onMounted, ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";
import moment from 'moment';
import {value} from "lodash/seq.js";

let props = defineProps({
    propertyRents: Object,
    property_id: {
        type: [Number, String]
    },
    rent_amount: {
        type: [Number, String]
    },
    lateFee: {
        type: [Number, String]
    },
    currentLateFee: {
        type: [Number, String]
    },
    grace_period: {
        type: [Number, String]
    },
    payment_date: {
        type: String,
        default() { return new Date().toISOString().split("T")[0]; }
    },
})

// onMounted(() => {
//     form.payment_date = moment().format('MM/DD/YYYY');
//     props.propertyRents.payment_date = moment().format('MM/DD/YYYY');
//     console.log(form.payment_date)
// });

const disabled = ref(true)


const modalActive = ref(true)
const isLoading = ref(false)

let form = useForm({
    'id': props.propertyRents ? props.propertyRents.id : '',
    'property_id': props.propertyRents ? props.propertyRents.property_id : props.property_id,

    'payment_amount': props.propertyRents ? props.propertyRents.payment_amount : props.rent_amount,
    'payment_date': props.propertyRents ? props.propertyRents.payment_date : new Date(props.payment_date).toISOString().split("T")[0],
    'late_fee': props.propertyRents ? props.propertyRents.late_fee : props.lateFee,
    'grace_period': props.propertyRents ? props.propertyRents.grace_period : props.grace_period,
})

let submit = () => {
    form.post(route('property-rent.store'), {
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
    form.get(route('property-rent.show',
        (props.propertyRents && props.propertyRents.property_id) ?
            props.propertyRents.property_id :  props.property_id))
}

watch(() => form.payment_date, (newVal, oldVal) => {
    if(!form.id){
        router.get(route('property-rent.createPropertyRent', form), {
            params: {
                payment_date: newVal
            }
        })
    }
})
</script>
