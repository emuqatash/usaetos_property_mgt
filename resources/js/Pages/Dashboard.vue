<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div>
            <div class="text-gray-900">You're logged in!</div>
        </div>
    </AuthenticatedLayout>
</template>
