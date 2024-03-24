<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <ul class="flex border-b-2 mb-4 justify-between">
            <li v-for="(title, index) in tabTitles" :key="index" class="-mb-px mr-1">
                <a
                    @click="selectedTitle = title"
                    class="bg-white border-b  border-l border-t border-r rounded-t py-2 px-4 text-blue-600 font-semibold cursor-pointer"
                    :class="[selectedTitle == title ? 'border-blue-500 text-blue-500' : 'text-blue-500 hover:text-blue-800']"
                >{{ title }}</a>
            </li>
        </ul>
        <slot />
    </div>
</template>
<script setup>
import {ref, provide, onMounted} from 'vue';

let selectedTitle = ref('')
let tabTitles = ref([])

onMounted( () => {
    selectedTitle.value = selectedTitle.value ? selectedTitle.value : tabTitles.value[0];
})

provide('selectedTitle', selectedTitle)

const setTitle = (title) => {
    tabTitles.value.push(title)
}

provide('setTitle', setTitle)
</script>

