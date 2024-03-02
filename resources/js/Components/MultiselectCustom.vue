<template>
    <div class="relative inline-block w-full">
        <div class="relative w-full" @click="open = !open">
            <div class="cursor-pointer w-12/12 pr-12 px-4 py-2 border border-gray-300 rounded-sm flex items-center">
                {{ selectedOption }}
            </div>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1">
                                    <SelectorIcon class="h-5 w-5 text-gray-500"/></span>
        </div>
        <div v-if="open" class="bg-white rounded-sm shadow-lg z-10 absolute min-w-full mt-1">
            <div
                v-for="option in options"
                :key="option.value"
                @click="selectOption(option)"
                class="cursor-pointer px-4 py-2 hover:bg-blue-500 hover:text-white"
            >
            {{option}}
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineEmits, ref} from 'vue';
import {SelectorIcon} from "@heroicons/vue/solid";

const props = defineProps({
    options: Array,
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);

let open = ref(false);
const selectOption = (option) => {
    selectedOption.value = option;
    open.value = false;
    emit('update:modelValue', option);
}
let selectedOption = ref(props.modelValue || 'Select an option');
</script>
