<template>
    <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700">{{ title }}</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <button
                @click="selectOption(option1)"
                type="button"
                class="flex-1 inline-flex justify-center py-3 px-4 border border-r-0 rounded-l-md bg-white text-sm
                                        font-medium text-gray-700 focus:ring-offset-2 focus:ring-indigo-500"
                :class="{ 'bg-blue-400 text-white' : selectedButton === option1 }">{{ option1 }}
            </button>
            <button
                @click="selectOption(option2)"
                type="button"
                class="flex-1 inline-flex justify-center py-3 px-4 border rounded-r-md bg-white text-sm font-medium
                                        text-gray-700 focus:ring-offset-2 focus:ring-indigo-500"
                :class="{ 'bg-blue-400 text-white' : selectedButton === option2 }">{{ option2 }}
            </button>
        </div>
    </div>
</template>

<script setup>
import {defineEmits, ref, watchEffect} from 'vue';

let props = defineProps({
        modelValue: String,
        title: String,
        option1: String,
        option2: String
})

let emit = defineEmits(['update:modelValue'])

const selectedButton = ref(props.modelValue);
const selectOption = (option) => {
    if (selectedButton.value === option) {
        selectedButton.value = null;

    } else {
        selectedButton.value = option;
    }
    emit('update:modelValue', selectedButton.value)
}

watchEffect(() => {
    if (props.modelValue !== selectedButton.value) {
        selectedButton.value = props.modelValue;
    }
});
</script>
