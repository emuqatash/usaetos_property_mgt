<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    class: String,
});
</script>
<template>
    <button
        :type="type"
        :class="class"
        class="
        inline-flex
        items-center
        px-3 py-2
        rounded-md
        bg-blue-600
        text-sm
        font-semibold
        text-white
        shadow-sm
        hover:bg-blue-500
        focus-visible:outline
        focus-visible:outline-2
        focus-visible:outline-offset-2
        focus-visible:outline-blue-600"
    >
        <div class="inline-flex items-center justify-center">
            <slot/>
        </div>
    </button>
</template>
<style scoped>
</style>
