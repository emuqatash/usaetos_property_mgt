<template>
    <AppModal :modalActive="modalActive">
        <div class="w-full h-full p-4 flex justify-between border-b border-gray-100">
            <div class="flex items-center">
                <SearchIcon class="w-5 h-5 mr-2.5 text-gray-500"/>
                <input v-model="search" type="text" placeholder="Search Contacts..."
                       class="border-0 text-base p-0"/>
            </div>
            <div class="flex items-center">
                <SecondaryButton
                    class="text-xs xl:text-sm font-bold xl:px-3"
                    @click="createContact()"
                >
                    <UserAddIcon class="w-5 h-5 inline-block section-button-icon xl:mr-2 text-blue-800"/>
                    <span class="hidden md:inline-block">New Contact</span>
                </SecondaryButton>
                <XIcon class="flex bg-white text-black items-center h-6 w-6 ml-4 cursor-pointer"
                       @click="cancel"/>
            </div>
        </div>
        <div class="flex px-6">
            <div class="w-1/3 overflow-y-scroll max-h-[600px]">
                <template v-if="contact">
                    <ul v-for="(eachContact, index) in contact" :key="index"
                        :class="{ 'divide-y divide-gray-10': selectedRows.includes(eachContact.id) }">
                        <li class="gap-x-4 py-5 flex justify-between pl-2 pr-6 cursor-pointer hover:bg-gray-100"
                            @click="selectRow(eachContact)"
                            :class="{ 'bg-gray-100': selectedId === eachContact.id }">
                            <div class="flex">
                                <img
                                    v-if="eachContact.profile_photo_path"
                                    :src="getImageUrl(eachContact.profile_photo_path)"
                                    alt="Contact Photo"
                                    class="h-12 w-12 flex-none rounded-full bg-gray-50">
                                <UserIcon v-if="!eachContact.profile_photo_path"
                                          class="rounded-full bg-gray-400 text-gray-50 p-1 h-12 w-12 flex-none"/>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold leading-6 text-gray-900 ml-2">
                                        {{ eachContact.first_name }}
                                        {{ eachContact.last_name }}</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500 ml-2">
                                        {{ eachContact.contact_type_name }}</p>
                                </div>
                            </div>
                            <div v-if="selectedId === eachContact.id">
                                <input
                                    type="checkbox"
                                    :value="eachContact.id"
                                    @change="toggleSelection(eachContact.id)"
                                    :checked="selectedId === eachContact.id">
                            </div>
                        </li>
                    </ul>
                </template>
                <template v-else>
                    <div class="font-semibold leading-6 text-gray-900 p-2">
                        <p>No Results Found</p>
                    </div>
                </template>
            </div>
            <div class="w-2/3 flex flex-col items-center justify-center" v-if="selectedId === null">
                <p class="md:text-2xl font-bold text-gray-400 p-0 lg:p-72 whitespace-nowrap">No Selected Contact</p>
            </div>

            <div class="w-2/3 flex flex-col items-center justify-center p-0 lg:p-20" v-if="selectedId !== null">
                <img
                    v-if="selectedContact.profile_photo_path"
                    :src="getImageUrl(selectedContact.profile_photo_path)"
                    alt="Contact Photo"
                    class="inline-block h-32 w-32 rounded-full"
                >
                <UserIcon v-if="!selectedContact.profile_photo_path"
                          class="rounded-full bg-gray-400 text-gray-50 p-1 h-32 w-32 flex-none"/>
                <p class="mt-4 text-xl font-semibold">{{ selectedContact.first_name }} {{
                        selectedContact.last_name
                    }}</p>
                <p class="text-base text-gray-700">{{ selectedContact.contact_type_name }}</p>
                <div class="mt-6 text-center">
                    <p class="text-base text-gray-700">{{ selectedContact.address }}</p>
                    <div class="flex whitespace-break-spaces">
                        <p class="text-base text-gray-700">{{ selectedContact.city }}, </p>
                        <p class="text-base text-gray-700">{{ selectedContact.state_name }}, </p>
                        <p class="text-base text-gray-700">{{ selectedContact.zip }} </p>
                    </div>
                    <p class="text-base text-gray-700">{{ selectedContact.phone_number }}</p>
                    <p class="text-base text-gray-700">{{ selectedContact.email }}</p>
                </div>
                <div class="m-6 text-center">
                    <SecondaryButton class="text-sm font-bold px-7" @click="editContact(selectedContact)">
                        Edit
                    </SecondaryButton>
                </div>
            </div>
        </div>
        <!--Buttons-->
        <div class="p-8 flex justify-around md:justify-start gap-2 bg-gray-50">
            <div>
                <AppButton class="px-8 py-2.5" @click="select(selectedContact)">Save</AppButton>
            </div>
            <div>
                <SecondaryButton @click="cancel">Cancel</SecondaryButton>
            </div>
        </div>
    </AppModal>
</template>

<script setup>
import {UserAddIcon, SearchIcon} from '@heroicons/vue/outline';
import {UserIcon, XIcon} from '@heroicons/vue/solid';
import AppModal from "@/Components/AppModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {computed, defineEmits, onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import AppButton from "@/Components/AppButton.vue";

const modalActive = ref(true)

let props = defineProps({
    contact: Object,
    selectedContactId: Number,
})

const search = ref('')
const contacts = ref(props.contact);
const selectedRows = ref([]);
const selectedId = ref(null);
const selectedContact = ref(null);
const selectedContactData = ref([]);

const emit = defineEmits(['cancel', 'selectedContact']);

onMounted(() => {
    if (props.selectedContactId) {
        selectedContactData.value = props.contact.data.find(contact => contact.id === props.selectedContactId)
        selectRow(selectedContactData.value)
    }
});

const contact = computed(() => {
    if (!search.value) {
        return props.contact; // Return all contacts if search is empty
    }
    // Return contacts that match the search query
    return contacts.value.filter(contact => {
        const searchTerm = search.value.toLowerCase();
        return contact.first_name.toLowerCase().includes(searchTerm) ||
            contact.last_name.toLowerCase().includes(searchTerm) ||
            contact.id.toString() === searchTerm; // Assuming you want to search by ID as well
    });
});

const toggleSelection = (id) => {
    const index = selectedRows.value.indexOf(id);
    if (index > -1) {
        selectedRows.value.splice(index, 1); // Remove if already selected
        selectedId.value = null;
    } else {
        selectedRows.value.push(id); // Add to selection if not already selected
    }
};
const selectRow = (contact) => {
    selectedId.value = contact.id;
    selectedContact.value = {...contact};
    // select(selectedContact.value);
};

const createContact = () => {
    router.get(route('contacts.create'))
}

const cancel = () => {
    emit('cancel');
}

const select = (selectedContact) => {
    emit('selectedContact',  selectedContact);
}

const editContact = (contact) => {
    router.get(route('contacts.edit', contact.id))
}
const getImageUrl = (path) => {
    return path ? `/storage/${path}` : null;
};
</script>
