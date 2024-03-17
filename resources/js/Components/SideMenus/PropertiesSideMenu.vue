<template>
    <div class="text-lg sm:text-2xl font-bold">Properties</div>
    <nav class="flex flex-1 flex-col">
        <ul v-if="$page.props.filters" role="list" class="flex flex-1 flex-col gap-y-7 mt-4 sm:mt-8 w-full sm:w-3/4 overflow-x-scroll sm:overflow-x-hidden px-2">
            <li>
                <ul role="list" class="-mx-2 space-x-4 sm:space-x-0 sm:space-y-2 flex sm:block items-center sm:items-start w-full">
<!--                    <Link :href="route('property.index')"-->
<!--                          :class="[!$page.props.filters?.propertyStatus && !$page.props.filters?.active ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',-->
<!--                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">-->
<!--                        <MenuIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>-->
<!--                        All-->
<!--                    </Link>-->
                    <li>
                        <div class="border-t border-gray-300 lg:mt-4"></div>
                        <Link :href="route('property.index', { active: '1' })"
                              :class="[$page.props.filters?.active === '1' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                   'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <CheckCircleIcon  class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            Active ({{$page.props.counts.active}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('property.index', { active: 'Inactive' })"
                              :class="[$page.props.filters?.active === 'Inactive' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                               'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <XCircleIcon   class="w-6  section-button-icon mr-2 hidden md:inline-block"/>
                            Inactive ({{$page.props.counts.inactive}})
                        </Link>
                    </li>
                    <li>
                        <div class="border-t border-gray-300 lg:mt-4"></div>
                        <Link :href="route('property.index', { propertyStatus: 'Vacant' })"
                              :class="[$page.props.filters?.propertyStatus === 'Vacant' ? 'text-blue-600 bg-gray-100' :
                              'text-black hover:text-blue-500 hover:bg-gray-100',
                               $page.props.counts.vacant >= 1 ? ' text-red-500' : '',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                          ]">
                            <OfficeBuildingIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            Vacant ({{$page.props.counts.vacant}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('property.index', { propertyStatus: 'Rented' })"
                              :class="[$page.props.filters?.propertyStatus === 'Rented' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <OfficeBuildingIcon class="w-6 section-button-icon mr-2 text-gray-600 bg-gray-400 hidden md:inline-block"/>
                            Rented ({{$page.props.counts.rented}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('property.index', { propertyStatus: 'Under Maintenance' })"
                              :class="[$page.props.filters?.propertyStatus === 'Under Maintenance' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <ExclamationCircleIcon  class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            UM ({{$page.props.counts.under_maintenance}})
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('property.index', { propertyStatus: 'Occupied' })"
                              :class="[$page.props.filters?.propertyStatus === 'Occupied' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <KeyIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            Occupied ({{$page.props.counts.occupied}})
                        </Link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>
<script setup>
import {Link} from '@inertiajs/vue3'
import {OfficeBuildingIcon,MenuIcon, KeyIcon,ExclamationCircleIcon,XCircleIcon,CheckCircleIcon } from "@heroicons/vue/outline"

</script>
