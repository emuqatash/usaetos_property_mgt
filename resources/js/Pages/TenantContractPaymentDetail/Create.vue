<template>
<AuthenticatedLayout :sub-menu="'TENANTCONTRACTS'">
<AppModal :modalActive="modalActive">
    <div class="w-full h-full p-4 justify-between border-b border-gray-100 overflow-auto max-h-screen">
    <form @submit.prevent="submit">
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
<!--        <div class="lg:flex">-->
            <div class="p-6 space-y-6 md:space-y-2 relative border-b border-gray-100 ">
                <p class="text-xl font-semibold mb-6" v-if="!form.id">Add Payment Plan</p>
                <p class="text-xl font-semibold mb-6" v-if="form.id">Update Payment Plan</p>
                <!--1row-->
                <div class="lg:flex gap-2 space-y-4 md:space-y-0">
                    <div class="flex-grow">
                        <Editable
                            type="text"
                            label="Amount"
                            :input-value="form.payment_amount"
                            @update:value="form.payment_amount = $event"
                            :error="form.errors.payment_amount"/>
                    </div>
                    <div class="flex-grow">
                        <Editable
                            type="date"
                            label="Payment Date"
                            :input-value="form.payment_date"
                            @update:value="form.payment_date = $event"
                            :error="form.errors.payment_date" />
                    </div>
                </div>
            </div>
<!--        </div>-->

        <!--Buttons-->
        <div class="p-6 flex justify-around md:justify-start gap-2 bg-gray-50">
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
import {useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
import AppModal from "@/Components/AppModal.vue";
import moment from 'moment';

let props = defineProps({
    tenantContractPaymentDetails: Object,
    tenantContract_id: {
        type: [Number, String]
    },
    monthlyRent: {
        type: [Number, String]
    },
})

// const currentDate = ref('');
// onMounted(() => {
//     form.payment_date = moment().format('MM/DD/YYYY');
//     console.log(form.payment_date)
// });

if(props.tenantContractPaymentDetails && !props.tenantContractPaymentDetails.payment_date) {
    props.tenantContractPaymentDetails.payment_date = moment().format('MM/DD/YYYY');
}

const modalActive = ref(true)
const isLoading = ref(false)

let form = useForm({
    'id': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.id : '',
    'tenantContract_id': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.tenantContract_id : props.tenantContract_id,

    'payment_amount': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.payment_amount : props.monthlyRent,
    // 'payment_date': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.payment_date : currentDate.value,
    'payment_date': props.tenantContractPaymentDetails ? props.tenantContractPaymentDetails.payment_date : '',
})

let submit = () => {
    form.post(route('tenant-contract-payment-detail.store'), {
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
    form.get(route('tenant-contract-payment-detail.show',
        (props.tenantContractPaymentDetails && props.tenantContractPaymentDetails.tenantContract_id) ?
            props.tenantContractPaymentDetails.tenantContract_id :  props.tenantContract_id))
}

const labelClass = 'block tracking-wide text-gray-700 text-xs font-bold mb-2'
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
