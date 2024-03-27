<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogoForLogin from "@/Components/ApplicationLogoForLogin.vue";
</script>
<template>

    <div class="min-h-screen md:gap-40 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <div class="w-full md:w-6/12 md:p-10 md:mr-32 sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
            <div class="pb-14">
                <div class="mb-14">
                    <Link href="/">
                        <ApplicationLogoForLogin class="h-20 fill-current" />
                    </Link>
                </div>
                <div>
                    <p class="mt-6 text-left text-xl font-extrabold text-black">
                        Welcome to "LeaseEase" Property Management, please sign in to your account
                    </p>
                </div>
            </div>

            <slot />
        </div>
        <div class="hidden md:flex md:w-8/12 items-center justify-center md:h-screen md:object-cover">
            <img src="/images/back_ground_login.jpg" alt="Background" class="md:min-h-screen ">
        </div>
    </div>
</template>
