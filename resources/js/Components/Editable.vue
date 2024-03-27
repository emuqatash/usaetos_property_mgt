<template>
    <label :for="id" :class="labelClass">{{ label }}</label>
    <template v-if="type === 'date'">
        <input
            :id="id"
            type="date"
            :value="inputValue" @input="$emit('update:value', $event.target.value)"
            :required="required"
            :class="inputClass"
            :disabled="disabled"
        >
        <div v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</div>
    </template>
    <template v-else-if="type === 'text'">
        <input
            :id="id"
            type="text"
            :value="inputValue" @input="$emit('update:value', $event.target.value)"
            :required="required"
            :class="inputClass"
            :disabled="disabled"
            :placeholder="placeholder"
        >
        <div v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</div>
    </template>
    <template v-else-if="type === 'number'">
        <input
            :id="id"
            type="number"
            :value="inputValue" @input="$emit('update:value', $event.target.value)"
            :required="required"
            :class="inputClass"
            :disabled="disabled"
        >
        <div v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</div>
    </template>
    <template v-else-if="type === 'textarea'">
        <textarea
            :id="id"
            :value="inputValue" @input="$emit('update:value', $event.target.value)"
            :required="required"
            :class="inputClass"
            :disabled="disabled"
        ></textarea>
        <div v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</div>
    </template>

</template>

<script>
import { defineComponent } from 'vue';
import VueMultiselect from 'vue-multiselect';

export default defineComponent({

    components: {
        VueMultiselect,
    },

    props: {
        label: {
            type: String,
            required: true,
        },
        inputValue: {
            type: [String, Number],
            required: false,
        },
        required: {
            type: Boolean,
            default: false,
        },
        error: {
            type: String,
            required: false,
        },
        type: {
            type: String,
            default: 'text',
        },
        selectOptions: {
            type: Array,
            required: false,
            default: () => [],
        },
        placeholder: {
            type: [String,Number],
            required: false,
            default: '',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        customStyle: {
            type: String,
            required: false,
            default: '',
        },
    },

    data() {
        return {
            inputClass: `appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 ${this.customStyle}`,
            labelClass: 'block tracking-wide text-gray-700 text-xs font-bold mb-2',
            inputButton: 'inline-flex items-center px-3 py-2 rounded-md bg-blue-600 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600',
        }
    },

    methods: {

    },

    computed: {
        id() {
            // Generate a unique ID for the input element
            return `form-editable-${Math.floor(Math.random() * 100000)}`;
        },
    },
});
</script>
