
<template>
    <Head title="Invoices | Drafts" />

    <AuthenticatedLayout :sub-menu="'INVOICES'">
        <div class="flex justify-between items-center mb-8">
            <div class="relative rounded-md shadow-sm mr-8">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Search...">
            </div>
            <SecondaryButton class="text-xs xl:text-sm font-bold xl:px-3">
                <PlusIcon class="w-5 h-5 inline-block section-button-icon xl:mr-2 text-blue-800" />
                <span class="hidden md:inline-block">New Invoice</span>
            </SecondaryButton>
        </div>
        <empty-state-invoices />
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import EmptyStateEstimates from '@/Pages/Estimates/EmptyStateEstimates.vue'
import EmptyStateContracts from '@/Pages/Contracts/EmptyStateContracts.vue'
import EmptyStateInvoices from '@/Pages/Invoices/EmptyStateInvoices.vue'
import AppButton from "@/Components/AppButton.vue";
import {PlusIcon} from "@heroicons/vue/outline";
import SecondaryButton from "@/Components/SecondaryButton.vue";
</script>
