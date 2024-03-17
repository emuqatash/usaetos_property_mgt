<template>
    <div class="text-lg sm:text-2xl font-bold">Tenants</div>
    <nav class="flex flex-1 flex-col">
        <ul v-if="$page.props.filters" role="list" class="flex flex-1 flex-col gap-y-7 mt-4 sm:mt-8 w-full sm:w-3/4 overflow-x-scroll sm:overflow-x-hidden px-2">
            <li>
                <ul role="list" class="-mx-2 space-x-4 sm:space-x-0 sm:space-y-2 flex sm:block items-center sm:items-start w-full">
                    <li>
                        <div class="border-t border-gray-300 lg:mt-4"></div>
                        <Link :href="route('tenant.index', { active: '1' })"
                              :class="[$page.props.filters?.active === '1' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <CheckCircleIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            Active ({{$page.props.counts?.active}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('tenant.index', { active: 'Inactive' })"
                              :class="[$page.props.filters?.active === 'Inactive' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                               'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <XCircleIcon   class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            Inactive ({{$page.props.counts?.inactive}})
                        </Link>
                    </li>
<!--                    <li>-->
<!--                        <Link :href="route('tenant.index')"-->
<!--                              :class="[(Object.keys($page.props.filters).length === 0 ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100'),-->
<!--                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">-->
<!--                            <MenuIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>-->
<!--                            All-->
<!--                        </Link>-->
<!--                    </li>-->
                    <div class="text-lg sm:text-lg font-simibold hidden md:inline-block pt-4">Contracts Expired in:</div>
                    <li>
                        <div class="border-t border-gray-300 lg:mt-4"></div>
                        <Link :href="route('tenant.index', { contractStatus: 'expired_contracts' })"
                              :class="[$page.props.filters?.contractStatus === 'expired_contracts' ? 'text-blue-600 bg-gray-100' :
                              'text-black hover:text-blue-500 hover:bg-gray-100',
                               $page.props.counts.expired_contracts >= 1 ? ' text-red-500' : '',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                          ]">
                            <DocumentRemoveIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            Expired ({{$page.props.counts?.expired_contracts}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('tenant.index', { contractStatus: 'expired_contracts_30_days' })"
                              :class="[$page.props.filters?.contractStatus === 'expired_contracts_30_days' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <ClockIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            30 Days ({{$page.props.counts?.expired_contracts_30_days}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('tenant.index', { contractStatus: 'expired_contracts_60_days' })"
                              :class="[$page.props.filters?.contractStatus === 'expired_contracts_60_days' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <ClockIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            60 Days ({{$page.props.counts?.expired_contracts_60_days}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('tenant.index', { contractStatus: 'expired_contracts_90_days' })"
                              :class="[$page.props.filters?.contractStatus === 'expired_contracts_90_days' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <ClockIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            90 Days ({{$page.props.counts?.expired_contracts_90_days}})
                        </Link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>
<script setup>
import {Link} from '@inertiajs/vue3'
import {
    MenuIcon,
    CheckCircleIcon,
    DocumentRemoveIcon,
    XCircleIcon,
    ClockIcon
} from "@heroicons/vue/outline"

</script>
