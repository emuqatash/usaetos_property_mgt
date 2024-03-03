<template>
    <div v-if="pagination.data.length">
        <nav class="bg-white px-4 py-3 flex items-center justify-between sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ pagination.from }}</span> to <span
                    class="font-medium">{{ pagination.to }}</span> of <span class="font-medium">{{
                        pagination.total
                    }}</span> results
                </p>
            </div>
            <div class="flex-1 flex justify-between lg:justify-end gap-2">
                <template v-for="link in pagination.links" :key="link.label">
                    <template v-if="link.label === 'Previous' || link.label === 'Next'">
                        <Link
                            preserve-scroll
                            :href="link.url ?? ''"
                            v-html="link.label"
                            :class="[paginationClass, {'bg-gray-200' : link.active, '!text-gray-300' : !link.url}]"
                        />
                    </template>
                </template>
            </div>
        </nav>
    </div>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    pagination: Object
});

const paginationClass = "relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 " +
    "font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue " +
    "focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150";

</script>
