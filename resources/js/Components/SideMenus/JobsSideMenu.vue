<template>
    <div class="text-lg sm:text-2xl font-bold">Jobs</div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7 mt-4 sm:mt-8 w-full sm:w-3/4 overflow-x-scroll sm:overflow-x-hidden px-2">
            <li>
                <ul role="list" class="-mx-2 space-x-4 sm:space-x-0 sm:space-y-2 flex sm:block items-center sm:items-start w-full">
                    <li>
                        <Link :href="route('jobs.index', { jobStatus: 'New' })"
                        :class="[$page.props.jobStatus === 'new' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <svg class="h-6 w-6 shrink-0"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            New
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('jobs.index', { jobStatus: 'Sold' })"
                              :class="[$page.props.jobStatus === 'Sold' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <svg class="h-6 w-6 shrink-0"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Sold
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('jobs.index', { jobStatus: 'Billed' })"
                              :class="[$page.props.jobStatus === 'Billed' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <svg class="h-6 w-6 shrink-0" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Billed
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('jobs.index', { jobStatus: 'Completed' })"
                              :class="[$page.props.jobStatus === 'Sold' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <svg class="h-6 w-6 shrink-0" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Completed
                        </Link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>
<script setup>
import {Link} from '@inertiajs/vue3'
</script>
