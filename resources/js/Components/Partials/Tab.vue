<template>
    <div v-show="selected">
        <slot></slot>
    </div>
</template>

<script setup>
import { inject, onMounted, computed } from 'vue'; // Add computed here

const props = defineProps({
    title: { type: String, required: true },
});

const selectedTitle = inject('selectedTitle')
const setTitle = inject('setTitle')

const selected = computed(() => props.title === selectedTitle.value)

// Register and unregister the Tab
onMounted(() => {
    setTitle(props.title)
})
</script>
