<template>
    <Head title="Settings | Team"/>
    <AuthenticatedLayout :sub-menu="'SETTINGS'">
        <CreateUser v-model:show="showInviteUser" v-model:errors="props.errors"/>
        <div class="space-y-16 sm:space-y-20">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                        <p class="mt-2 text-sm text-gray-700 hidden xl:block">A list of all the users in your account
                            including their name, title, email and role.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <SecondaryButton
                            class="text-xs xl:text-sm font-bold xl:px-1"
                            @click="showInviteUser = true"
                        >
                            <UserAddIcon
                                class="w-6 h-5 inline-block section-button-icon text-blue-800 mr-1"
                            />
                            Create User
                        </SecondaryButton>
                    </div>
                </div>
                <div class="-mx-4 mt-8 sm:-mx-0">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0  sm:w-[160px]">
                                Name
                            </th>
                            <th scope="col"
                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                Email
                            </th>
                            <th scope="col" class="px-8 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Access
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="user in props.users">
                            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-[160px] sm:pl-0">
                                {{ user.name }}
                                <dl class="font-normal lg:hidden">
                                    <dt class="sr-only lg:hidden">Email</dt>
                                    <dd class="mt-2 text-gray-500 lg:hidden">{{ user.email }}</dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ user.email }}</td>
                            <td class="px-8 py-4 text-sm text-gray-500 text-wrap">{{ user.role.name }}</td>
                            <td class="hidden px-3 py-4 text-xs text-gray-500">Limited access to personal</td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 space-x-2">
                                <Link :href="route('settings.team.user', user.id)" type="button"
                                      class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Edit
                                </Link>
                                <button
                                    type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-red-600 hover:bg-red-400"
                                    @click="confirmDelete(user.id)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--------------------Popup Confirmation Delete--------------------------->
        <ConfirmationModal
            @onConfirm="deleteRecordConfirmed(deleteRecordId)"
            @onCancel="closeModel"
            :show="modalActive"
            :message="'Confirm Account Deletion?'"
            confirmLabel="Yes, delete it!"
            cancelLabel="Cancel"
        />
        <!--------------------Popup Confirmation Delete--------------------------->
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import InviteUser from '@/Pages/Settings/Team/InviteUser.vue'
import {ref} from 'vue'
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {UserAddIcon} from '@heroicons/vue/outline';
import Register from "@/Pages/Auth/Register.vue";
import CreateUser from "@/Pages/Auth/CreateUser.vue";
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";

const showInviteUser = ref(false)
const modalActive = ref(false)
const deleteRecordId = ref(null);

const props = defineProps({
    users: Array,
    errors: Object,
})

const confirmDelete = (id) => {
    deleteRecordId.value = id;
    modalActive.value = true;
}
const closeModel = () => {
    modalActive.value = false;
}
const deleteRecordConfirmed = (id) => {
    router.get(route('user.destroy', id))
    modalActive.value = false;
}


</script>
