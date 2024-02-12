<script setup>
import {reactive} from 'vue'
import {router} from '@inertiajs/vue3'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    errors: Object,
})

const emit = defineEmits(['update:show', 'update:errors'])

const close = () => {
    emit('update:errors', null)
    emit('update:show', false)
}

const open = () => {
    emit('update:errors', null)
    emit('update:show', true);
}

const newUser = reactive({
    email: '',
    role: 1
})

const save = () => {
    emit('update:errors', null)
    router.post(route('settings.team.invite'),
        {
            email: newUser.email,
            role: newUser.role
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                close()
            },
            onError: (errors) => {
                emit('update:errors', errors)
            }
    })
}

</script>

<template>
    <div v-if="show" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center text-center sm:items-center">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                    <div class="flex justify-between items-center p-6 pb-0">
                        <p class="text-xl font-semibold text-gray-900" id="modal-title">
                            Invite User
                        </p>
                        <svg @click="close" class="h-6 w-6 cursor-pointer" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <div class="p-6 pb-2">
                        <label for="email" class="block text-base font-semibold text-gray-700">Invite by Email</label>
                        <div class="mt-2">
                            <input v-model="newUser.email" type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="you@example.com">
                        </div>
                    </div>
                    <div class="p-6">
                        <label class="text-base font-semibold text-gray-700">Role</label>
                        <fieldset class="mt-4">
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input v-model="newUser.role" value="1" id="admin" name="role" type="radio" checked class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="admin" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Administrator</label>
                                </div>
                                <div class="flex items-center">
                                    <input v-model="newUser.role" value="2" id="sales" name="role" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="sales" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Sales</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <ul v-if="Object.keys(props.errors).length" class="mx-6 bg-red-500 text-red-50 p-4 text-sm rounded">
                        <li v-for="error in props.errors" class="list-disc ml-4">
                            {{ error }}
                        </li>
                    </ul>
                    <div class="bg-gray-100 p-6 flex items-center justify-between space-x-8">
                        <button @click="close" type="button" class="inline-flex justify-center w-full rounded-md border border border-gray-300 shadow-sm px-4 py-3 bg-white text-base font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:text-sm">
                            Cancel
                        </button>
                        <button @click="save" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:text-sm">
                            Invite User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
