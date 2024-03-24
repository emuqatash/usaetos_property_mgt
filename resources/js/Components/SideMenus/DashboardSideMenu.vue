<template>
    <div class="text-lg sm:text-2xl font-bold">DASHBOARD</div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7 mt-4 sm:mt-8 w-full sm:w-3/4 overflow-x-scroll sm:overflow-x-hidden px-2">
            <li>
                <li>
                    <Link :href="route('tenant.index', { contractStatus: 'expired_contracts_30_days' })"
                          :class="[$page.props.filters?.contractStatus === 'expired_contracts_30_days' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                        <ClockIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
<!--                        30 Days ({{$page.props.counts?.expired_contracts_30_days}})-->
                        Net Profit
                    </Link>
                </li>
            </li>
        </ul>
    </nav>
</template>
<script setup>
// import {Link} from '@inertiajs/vue3'

import {ClockIcon} from "@heroicons/vue/outline";
import {Link} from "@inertiajs/vue3";
</script>
