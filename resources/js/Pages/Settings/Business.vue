<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head, router} from '@inertiajs/vue3'
import {ref} from 'vue'
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    user: Object,
    company: Object,
    errors: Object,
})

const editSection = ref(null)
const editingSection = (section) => editSection.value === section
const edit = (section) => editSection.value = section
const save = () => {
    router.post(route('settings.business.update'), {
        user_id: props.user.id,
        company_id: props.company.id,
        field: editSection.value.toLowerCase(),
        value: props.company[editSection.value.toLowerCase()]
    })
    editSection.value = null
}
const cancel = () => editSection.value = null

const saveContractDetails = () => {
    editSection.value = 'contract_details'
    save()
}
</script>

<template>
    <Head title="Settings | Business" />

    <AuthenticatedLayout :sub-menu="'SETTINGS'">
        <div class="space-y-16 sm:space-y-20" >
            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Business Profile</h2>
                <p class="mt-1 text-sm leading-6 text-gray-500">Below are the basic details included for your business.</p>
                <div v-if="props.errors.value" class="absolute bottom-0 right-0 mb-12 mr-12 max-w-md bg-red-500 text-red-50 border rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700" role="alert">
                    <div class="flex p-4 items-center">
                        <div class="flex-shrink-0">
                            <svg @click="props.errors.value = null" class="cursor-pointer h-4 w-4 text-white-50 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class=" text-red-50 font-semibold dark:text-gray-400">
                                {{ props.errors.value }}
                            </p>
                        </div>
                    </div>
                </div>

                <dl class="mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
                    <div class="pt-6 sm:flex">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Business Name</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="">
                                <div v-if="!editingSection('NAME')" class="text-gray-900">{{ props.company.name }}</div>
                                <input v-if="editingSection('NAME')" type="text" v-model="props.company.name" placeholder="Full Name" class="block w-full rounded-md border-0 py-1 text-gray-900 shadow-sm placeholder:text-gray-400 ring-2 ring-inset ring-indigo-600 text-sm sm:leading-6">
                            </div>
                            <div>
                                <button @click="edit('NAME')" v-if="!editingSection('NAME')" type="button" class="inline-block px-4 py-1.5 rounded-md font-semibold text-indigo-600 hover:text-indigo-500">Edit</button>
                                <button @click="cancel()" v-if="editingSection('NAME')" type="button" class="inline-block px-4 py-1.5 rounded-md mr-1 font-semibold text-indigo-600 hover:text-indigo-500">Cancel</button>
                                <button @click="save()" v-if="editingSection('NAME')" type="button" class="inline-block  px-4 py-1.5 rounded-md font-semibold bg-indigo-600 text-indigo-50 hover:bg-indigo-500">Save</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Business Address</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="">
                                <div v-if="!editingSection('ADDRESS')" class="text-gray-900">{{ props.company.address }}</div>
                                <input v-if="editingSection('ADDRESS')" type="text" v-model="props.company.address" placeholder="Full Name" class="block w-full rounded-md border-0 py-1 text-gray-900 shadow-sm placeholder:text-gray-400 ring-2 ring-inset ring-indigo-600 text-sm sm:leading-6">
                            </div>
                            <div>
                                <button @click="edit('ADDRESS')" v-if="!editingSection('ADDRESS')" type="button" class="inline-block px-4 py-1.5 rounded-md font-semibold text-indigo-600 hover:text-indigo-500">Edit</button>
                                <button @click="cancel()" v-if="editingSection('ADDRESS')" type="button" class="inline-block px-4 py-1.5 rounded-md mr-1 font-semibold text-indigo-600 hover:text-indigo-500">Cancel</button>
                                <button @click="save()" v-if="editingSection('ADDRESS')" type="button" class="inline-block  px-4 py-1.5 rounded-md font-semibold bg-indigo-600 text-indigo-50 hover:bg-indigo-500">Save</button>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Contract Terms</h2>
                <p class="mt-1 text-sm leading-6 text-gray-500">Below is the content that will appear on contracts for your customers</p>

                <dl class="mt-6 space-y-6 divide-y divide-gray-100 text-sm leading-6">
                    <div class="mt-2 text-right">
                        <textarea v-model="props.company.contract_details" rows="16" name="comment" id="comment" class="mb-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        <SecondaryButton @click="saveContractDetails()" class="text-sm font-bold">Update</SecondaryButton>
                    </div>
                </dl>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
