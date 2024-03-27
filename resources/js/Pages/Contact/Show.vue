<template>
    <!-- Modal -->
    <AppModal :modalActive="showActive" width="w-full sm:max-w-5xl">
        <div class="lg:flex justify-center">
            <div class="p-14 relative border-b border-gray-100 space-y-4">
                <div class="flex flex-col items-center justify-center mb-4">
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-xl font-semibold">A Similar Tenant already exists</p>
                        <p class="text-xl mb-6 mt-1">Do you want to proceed and save a new Tenant</p>
                    </div>
                    <div class="mt-6 flex flex-col items-center justify-center">
                        <div v-if="url" class="relative inline-block">
                            <img
                                :src="url"
                                alt="Contact Photo"
                                class="rounded-full p-2 w-36 h-36">
                            <CheckCircleIcon
                                class="text-white w-12 h-13 absolute -top-0.5 -right-0.5"/>
                            <CheckCircleIcon
                                class="text-green-500 w-10 h-10 absolute top-0 right-0"/>
                        </div>
                        <UserIcon v-if="!url"
                                  class="rounded-full bg-gray-400 text-gray-50 p-2 w-32 h-32"/>

                        <p class="mt-2 text-xl font-semibold leading-6 text-gray-900">{{ form.first_name }}
                            {{ form.last_name }}</p>
                        <p class="leading-5 text-gray-500 mb-2">{{ props.selectedContactType.name }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 space-y-2">
                    <div class="font-semibold">Address</div>
                    <div class="text-base text-gray-700">{{ form.address }}</div>

                    <div class="font-semibold">City</div>
                    <div class="text-base text-gray-700">{{ form.city }}</div>

                    <div class="font-semibold">State</div>
                    <div class="text-base text-gray-700">{{ props.selectedState.name }}</div>

                    <div class="font-semibold">Zip</div>
                    <div class="text-base text-gray-700">{{ form.zip }}</div>

                    <div class="font-semibold">Phone</div>
                    <div class="text-base text-gray-700">{{ form.phone_number }}</div>

                    <div class="font-semibold">Email</div>
                    <div class="text-base text-gray-700">{{ form.email }}</div>
                </div>
            </div>
            <!--photo-->
        </div>

        <!--Buttons-->
        <div class="p-8 flex justify-center  gap-2 bg-gray-50">
            <SecondaryButton class="text-lg font-bold px-7" @click="cancel">
                Cancel
            </SecondaryButton>
            <AppButton class="text-lg font-bold px-7" @click="emitSubmit">
                Save Anyway
            </AppButton>
        </div>
    </AppModal>
</template>

<script setup>
import AppModal from "@/Components/AppModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref, defineEmits} from "vue";
import {useForm} from "@inertiajs/vue3";
import {UserIcon, CheckCircleIcon} from "@heroicons/vue/solid";
import AppButton from "@/Components/AppButton.vue";

const showActive = ref(true)
const emit = defineEmits(['submit-form', 'cancel']);

let props = defineProps({
    contact: Object,
    selectedState: Object,
    selectedContactType: Object,
    url: String
})

const form = useForm(props.contact)

const cancel = () => {
    emit('cancel');
}
const getImageUrl = (path) => {
    return path ? `/storage/${path}` : null;
};

const emitSubmit = () => {
    emit('submit-form', true);
};
</script>
