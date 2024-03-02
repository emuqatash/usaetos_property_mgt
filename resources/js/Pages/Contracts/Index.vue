<template>
    <!--    <Head title="Jobs | New"/>-->
    <AuthenticatedLayout :sub-menu="'CONTRACTS'">
        <div class="flex justify-between items-center mb-8">
            <div class="relative rounded-md shadow-sm mr-8">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <SearchIcon class="w-5 h-5 mr-2.5 text-gray-500"/>
                </div>
                <input type="text" name="search" id="search" v-model="search"
                       class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300
                   placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="Search...">
            </div>
            <SecondaryButton class="xl:text-sm font-bold" @click="newJob">
                <FolderAddIcon class="w-10 h-5 inline-block section-button-icon text-blue-800"/>
                <span class="hidden md:inline-block">New Job</span>
            </SecondaryButton>
        </div>
        <template v-if="job.data.length">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900"> {{ props.filters.jobStatus }} Jobs</h1>
                    <p v-if="props.filters.jobStatus === 'New'" class="mt-2 text-sm text-gray-700"> A list of all the Jobs that have been created but not
                        Sold.</p>
                    <p v-if="props.filters.jobStatus === 'Sold'" class="mt-2 text-sm text-gray-700"> A list of all the Sold Jobs.</p>
                    <p v-if="props.filters.jobStatus === 'Billed'" class="mt-2 text-sm text-gray-700"> A list of all the Billed Jobs.</p>
                    <p v-if="props.filters.jobStatus === 'Completed'" class="mt-2 text-sm text-gray-700"> A list of all the Completed Jobs.</p>
                </div>
            </div>
            <div class="-mx-4 mt-8 flow-root sm:mx-0">
                <table class="min-w-full">
                    <tbody>
                    <tr class="border-b border-gray-200"
                        v-for="(eachJob, index) in job.data" :key="index"
                        :class="{ 'divide-y divide-gray-10 ': selectedRows.includes(eachJob.id) }">
                        <td>
                            <div class="md:flex md:justify-between md:items-center">
                                <div class="relative rounded-md shadow-sm ">
                                    <div class="flex justify-start">
                                        <div>
                                            <FolderIcon
                                                class="text-gray-200 hidden md:inline-block w-14 h-14 section-button-icon
                                            md:mr-4"/>
                                        </div>
                                        <div>
                                            <p v-if="eachJob.salesmen.length !== 0" class="font-medium text-gray-900 mb-1">
                                                {{ eachJob.job_number }} </p>
                                            <p v-if="eachJob.salesmen.length === 0" class="font-medium text-orange-400 mb-1">
                                                Unassigned - {{ eachJob.job_number }} </p>
                                            <p class="text-sm text-gray-500 mb-4"> {{ eachJob.user }}
                                                created Job for {{ eachJob.customer }} in {{ eachJob.job_location }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:block flex justify-center mb-4">
                                    <SecondaryButton class="text-xs xl:text-sm font-bold" @click="showJob(eachJob)">
                                        <span class="md:inline-block">View Job</span>
                                    </SecondaryButton>
                                    <DotsVerticalIcon class="hidden md:inline-block ml-2 w-5 h-5 section-button-icon"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- More projects... -->
                    </tbody>
                </table>
            </div>
        </template>
        <template v-else>
            <EmptyStateJobs/>
        </template>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {DotsVerticalIcon, SearchIcon} from "@heroicons/vue/outline";
import {FolderIcon, FolderAddIcon} from '@heroicons/vue/solid';
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {debounce} from "lodash";
import EmptyStateJobs from "@/Pages/Job/EmptyStateJobs.vue";

let props = defineProps({
    job: Object,
    filters: Object,
})

const selectedRows = ref([])
const search = ref(props.filters.search)

watch(search, debounce(() => {
        router.get('/jobs', {search: search.value},
            {
                preserveState: true,
                replace: true
            })
    }, 500)
)

const newJob = () => {
    router.get(route('jobs.create'))
}
const showJob = (job) => {
    router.get(route('jobs.show', job.id))
}
</script>
