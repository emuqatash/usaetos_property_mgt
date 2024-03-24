<template>
    <div>
        <div class="min-h-screen bg-white">
            <nav class="relative bg-white border-b border-gray-200 grid grid-cols-8 py-4 px-8">
                <div class="flex items-center col-span-7 sm:col-span-1 xl:col-span-2">
                    <Link :href="route('dashboard')" class="flex items-center ">
                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 mr-2" />
                        <div class="hidden xl:block text-lg font-semibold">LeaseEase Property Management</div>
                     </Link>
                </div>
                <div class="hidden sm:flex sm:col-span-5 xl:col-span-4 justify-center  overflow-x-auto">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-6">
                            <Link :href="route('property.index')" :class="[$page.url.startsWith('/property') ? 'bg-gray-200 text-blue-600 ' : 'text-black hover:bg-gray-200 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">Properties</Link>
                            <Link :href="route('tenant.index')" :class="[$page.url.startsWith('/tenant') ? 'bg-gray-200 text-blue-600 ' : 'text-black hover:bg-gray-200 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">Tenants</Link>
                            <Link :href="route('tenant.index', { jobStatus: 'New' })" :class="[$page.url.startsWith('/tenants') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">*Maintenance*</Link>
                            <Link :href="route('tenant.index', { jobStatus: 'New' })" :class="[$page.url.startsWith('/tenants') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">*FollowUp*</Link>
<!--                            <Link :href="route('jobworks.index')" :class="[$page.url.startsWith('/job') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">Tasks</Link>-->
<!--                            <Link :href="route('invoices.drafts')" :class="[$page.url.startsWith('/invoices') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">Invoices</Link>-->
<!--                            <Link :href="route('purchase-orders.drafts')" :class="[$page.url.startsWith('/purchase-orders') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">PO</Link>-->
<!--                            <Link :href="route('supply.items')" :class="[$page.url.startsWith('/supply') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'rounded-md px-3 py-2 text-sm font-semibold']">Supply</Link>-->
                        </div>
                    </div>
                </div>
                <div class="flex col-span-1 sm:col-span-2 justify-end space-x-4">
                    <AppButton
                        class="hidden md:block"
                        @click="showContact()"
                    >
                        <UserAddIcon  class="w-6 lg:h-5 section-button-icon xl:mr-2" />
                        Contacts
                    </AppButton>
                    <CogIcon class="w-10 h-10 text-blue-600 hover:text-blue-500"/>
                    <Link :href="route('settings.profile')" class="hidden sm:inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                        <span class="font-medium leading-none text-white">{{ userInitials }}</span>
                    </Link>
                    <div class="flex items-center sm:hidden">
                        <!-- Mobile menu button-->
                        <button @click="showMobileMenu = !showMobileMenu" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>

                            <svg v-if="!showMobileMenu" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                            <svg v-if="showMobileMenu" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
            <div v-if="showMobileMenu" class="flex sm:hidden bg-gray-100 px-8" id="mobile-menu">
                <div class="space-y-1 py-4 w-full">
                    <Link :href="route('property.index')" :class="[$page.url.startsWith('/property') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Properties</Link>
                    <Link :href="route('tenant.index')" :class="[$page.url.startsWith('/tenant') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Tenants</Link>
                    <Link :href="route('tenant.index')" :class="[$page.url.startsWith('/tenant') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Maintenance</Link>
<!--                    <Link :href="route('jobworks.index', { jobStatus: 'New' })" :class="[$page.url.startsWith('/job') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Jobs</Link>-->
<!--                    <Link :href="route('invoices.drafts')" :class="[$page.url.startsWith('/invoices') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Invoices</Link>-->
<!--                    <Link :href="route('purchase-orders.drafts')" :class="[$page.url.startsWith('/purchase-orders') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">PO</Link>-->
<!--                    <Link :href="route('supply.items')" :class="[$page.url.startsWith('/supply') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Supply</Link>-->
                    <Link :href="route('settings.profile')" :class="[$page.url.startsWith('/supply') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Profile</Link>
                    <Link :href="route('settings.profile')" :class="[$page.url.startsWith('/supply') ? 'bg-gray-100 text-blue-600 ' : 'text-black hover:bg-gray-100 hover:text-gray-800 ', 'block rounded-md px-3 py-2 text-base font-semibold']">Settings</Link>
                </div>
            </div>
            <div class="bg-white grid grid-cols-8 py-4 px-8 sm:min-h-screen sm:mt-4">
                <div class="flex flex-col col-span-8 sm:col-span-2 mb-16 sm:mb-4">
                    <properties-side-menu v-if="props.subMenu === 'PROPERTIES'" />
                    <Tenants-side-menu v-if="props.subMenu === 'TENANTS'" />
                    <tenant-contracts-side-menu v-if="props.subMenu === 'TENANTCONTRACTS'" />
                    <expenses-Side-Menu v-if="props.subMenu === 'PROPERTYEXPENSES'" />
                    <property-rent-Side-Menu v-if="props.subMenu === 'PROPERTYRENTS'" />
                    <jobs-side-menu v-if="props.subMenu === 'JOBS'" />
                    <invoices-side-menu v-if="props.subMenu === 'INVOICES'" />
                    <purchase-orders-side-menu v-if="props.subMenu === 'PURCHASE_ORDERS'" />
                    <supply-side-menu v-if="props.subMenu === 'SUPPLY'" />
                    <settings-side-menu v-if="props.subMenu === 'SETTINGS'" />
                    <dashboard-side-menu v-if="props.subMenu === 'DASHBOARD'" />
                </div>
                <div class="flex col-span-8 sm:col-span-4 items-start pb-20">
                    <main class="px-4 sm:px-6 lg:flex-auto lg:px-0">
                        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                            <slot />
                        </div>
                    </main>
                </div>
                <div class="hidden sm:flex col-span-2"></div>
            </div>
        </div>

    </div>
</template>

<script setup>
import {ref,computed} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link, router, usePage} from '@inertiajs/vue3';
import SettingsSideMenu from '@/Components/SideMenus/SettingsSideMenu.vue';
import JobsSideMenu from '@/Components/SideMenus/JobsSideMenu.vue';
import InvoicesSideMenu from '@/Components/SideMenus/InvoicesSideMenu.vue';
import PurchaseOrdersSideMenu from '@/Components/SideMenus/PurchaseOrdersSideMenu.vue';
import SupplySideMenu from '@/Components/SideMenus/SupplySideMenu.vue';
import AppButton from "@/Components/AppButton.vue";
import { UserAddIcon } from "@heroicons/vue/solid/esm";
import PropertiesSideMenu from "@/Components/SideMenus/PropertiesSideMenu.vue";
import TenantsSideMenu from "@/Components/SideMenus/TenantsSideMenu.vue";
import ExpensesSideMenu from "@/Components/SideMenus/ExpensesSideMenu.vue";
import PropertyRentSideMenu from "@/Components/SideMenus/PropertyRentSideMenu.vue";
import TenantContractsSideMenu from "@/Components/SideMenus/TenantContractsSideMenu.vue";
import DashboardSideMenu from "@/Components/SideMenus/DashboardSideMenu.vue";
import {CogIcon, FolderAddIcon} from '@heroicons/vue/solid';

const showMobileMenu = ref(false)
const page = usePage()

const props = defineProps({
    subMenu: {
        type: String,
        default: true,
        required: true
    },
    errors: Object,
})

let userInitials = computed(() => {
    if (page.props.auth.user && page.props.auth.user.name) {
        let nameParts = page.props.auth.user.name.split(' ')
        let initials = nameParts[0].slice(0, 1)
        if (nameParts.length > 1) {
            initials += nameParts[nameParts.length - 1].slice(0, 1)
        }
        return initials.toUpperCase()
    }
    return 'PM' // default value
})

const showContact = () => {
    router.get(route('contacts.index'))
}
</script>
