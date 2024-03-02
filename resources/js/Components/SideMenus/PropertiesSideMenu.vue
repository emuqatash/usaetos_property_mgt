<template>
    <div class="text-lg sm:text-2xl font-bold">Properties</div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7 mt-4 sm:mt-8 w-full sm:w-3/4 overflow-x-scroll sm:overflow-x-hidden px-2">
            <li>
                <ul role="list" class="-mx-2 space-x-4 sm:space-x-0 sm:space-y-2 flex sm:block items-center sm:items-start w-full">
                    <li>
                        <Link :href="route('property.index')"
                              :class="[$page.props.filters.propertyStatus ? 'text-black hover:text-blue-500 hover:bg-gray-100' : 'text-blue-600 bg-gray-100', '' +
                               'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <MenuIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            All
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('property.index', { propertyStatus: 'Vacant' })"
                              :class="[$page.props.filters.propertyStatus === 'Vacant' ? 'text-blue-600 bg-gray-100' :
                              'text-black hover:text-blue-500 hover:bg-gray-100',
                               $page.props.counts.vacant >= 1 ? ' text-red-500' : '',
                               'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                          ]">
                            <OfficeBuildingIcon class="w-6 section-button-icon mr-2 hidden md:inline-block"/>
                            Vacant ({{$page.props.counts.vacant}})
                        </Link>
                    </li>

                    <li>
                        <Link :href="route('property.index', { propertyStatus: 'Occupied' })"
                              :class="[$page.props.filters.propertyStatus === 'Occupied' ? 'text-blue-600 bg-gray-100' : 'text-black hover:text-blue-500 hover:bg-gray-100',
                              'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <OfficeBuildingIcon class="w-6 section-button-icon mr-2 text-gray-600 bg-gray-400 hidden md:inline-block"/>
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
import {OfficeBuildingIcon,MenuIcon } from "@heroicons/vue/outline"

</script>
