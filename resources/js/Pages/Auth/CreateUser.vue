
<template>
    <Head title="Register"/>
        <AppModal :modalActive="show" width="sm:max-w-5xl">
            <div class="p-4 w-96 mx-auto">
            <form @submit.prevent="submit" v-if="show">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 mb-6" v-if="!form.id">Create User</h2>
                <div>
                    <InputLabel for="name" value="Name"/>

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email"/>

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="role" value="Role type"/>

                    <TextInput
                        id="role"
                        type="text"
                        value="Basic user account"
                        v-model="form.role"
                        aria-placeholder="User"
                        class="mt-1 block w-full bg-gray-200"
                        autofocus
                        disabled="disabled"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password"/>

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password"/>

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!--                <Link-->
                    <!--                    :href="route('login')"-->
                    <!--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
                    <!--                >-->
                    <!--                    Already registered?-->
                    <!--                </Link>-->

                    <!--                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
                    <!--                    Create-->
                    <!--                </PrimaryButton>-->
                    <!--Buttons-->
                    <div class="flex justify-around md:justify-start gap-2 bg-gray-50">
                        <div>
                            <LoadingButton type="submit" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing"
                                           class="px-8 py-2.5">
                                Create
                            </LoadingButton>
                        </div>
                        <div>
                            <SecondaryButton @click="close">
                                Cancel
                            </SecondaryButton>
                        </div>
                    </div>
                </div>

            </form>
            </div>
        </AppModal>

</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import ConfirmationModal from "@/Composables/ConfirmationModal.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    errors: Object,
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: ''
});

const modalActive = ref(null)
const emit = defineEmits(['update:show', 'update:errors'])

const close = () => {
    emit('update:errors', null)
    emit('update:show', false)
}

const submit = () => {
    // form.post(route('register'));
    form.post(route('register'), {
        onFinish: () => emit('update:show', false),
    });
};
</script>
