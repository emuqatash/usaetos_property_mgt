<template>
    <SwitchGroup as="div" class="flex gap-2 items-start">
        <SwitchLabel as="span" class="mb-1 font-medium text-gray-900 text-sm">Active</SwitchLabel>
        <Switch v-model="enabled" :class="{ 'bg-indigo-600': enabled, 'bg-gray-200': !enabled, 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2': true }">
            <span aria-hidden="true" :class="{ 'translate-x-5': enabled, 'translate-x-0': !enabled, 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out': true }"></span>
        </Switch>
    </SwitchGroup>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

const props = defineProps({
    modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const enabled = ref(props.modelValue)

watch(enabled, newValue => {
    emit('update:modelValue',  Boolean(newValue))
})
</script>
