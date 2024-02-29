<template>
    <div v-if="pagination.data.length">
        <nav class="bg-white px-4 py-3 flex items-center justify-between sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ pagination.from }}</span> to <span class="font-medium">{{ pagination.to }}</span> of <span class="font-medium">{{ pagination.total }}</span> results
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <a href="#" :class="paginationClass" :disabled="!pagination.prev_page_url" @click.prevent="changePage(pagination.prev_page_url)">
                    Previous
                </a>
                <a href="#" :class="`${paginationClass} ml-3`" :disabled="!pagination.next_page_url" @click.prevent="changePage(pagination.next_page_url)">
                    Next
                </a>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Define the props
const props = defineProps({
    pagination: Object
});

// Extract the prop
const pagination = ref(props.pagination);

// Get Inertia

// Method
const changePage = (url) => {
    if (url) {
        // visit(url);
    }
};

// Computed
const paginationClass = "relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150";

</script>
