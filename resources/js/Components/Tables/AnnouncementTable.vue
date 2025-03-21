<script setup>
import DeleteConfirmation from "@/Components/Modal/DeleteConfirmation.vue";
import { defineProps, ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    announcements: Array,
});

const showDeleteConfirmation = ref(false);
const announcementId = ref(null);

const navigateToEditAnnouncement = (id) => {
    router.visit(route("announcement.edit", { id }));
};

const openDeleteModal = (id) => {
    announcementId.value = id;
    showDeleteConfirmation.value = true;
};

const closeDeleteModal = () => {
    showDeleteConfirmation.value = false;
};
</script>

<template>
    <div
        class="h-full w-full overflow-hidden rounded-xl border-2 dark:border-[#3C4053] border-[#DDE3E7]"
    >
        <div
            class="overflow-y-auto no-scrollbar flex-grow min-h-0 max-h-[calc(100vh-239px)]"
        >
            <table class="w-full table-fixed">
                <thead class="sticky top-0 dark:bg-[#3C4053] bg-[#DDE3E7]">
                    <tr>
                        <th
                            class="w-2/10 pt-6 pb-2 px-6 text-start dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Title
                        </th>
                        <th
                            class="w-4/10 pt-6 pb-2 px-6 text-start dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Description
                        </th>
                        <th
                            class="w-2/10 pt-6 pb-2 px-6 text-start dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Date
                        </th>
                        <th
                            class="w-2/10 pt-6 pb-2 text-start dark:text-[#EEEEEE] text-[#222831] font-bold"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="announcement in props.announcements"
                        :key="announcement.id"
                    >
                        <td
                            class="border-b-2 dark:border-[#3C4053] border-[#DDE3E7] w-3/10 pe-4 pb-4 pt-2 px-6 text-start align-top dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.title }}
                        </td>
                        <td
                            class="border-b-2 dark:border-[#3C4053] border-[#DDE3E7] w-3/10 pe-4 pb-4 pt-2 px-6 text-start align-top dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.description }}
                        </td>
                        <td
                            class="border-b-2 dark:border-[#3C4053] border-[#DDE3E7] w-3/10 pe-4 pb-4 pt-2 px-6 align-top text-start dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.created_at }}
                        </td>
                        <td
                            class="border-b-2 dark:border-[#3C4053] border-[#DDE3E7] w-1/10 pb-4 pt-2 text-center dark:text-[#EEEEEE] text-[#222831]"
                        >
                            <div class="flex gap-4 items-center justify-center">
                                <button
                                    @click="
                                        navigateToEditAnnouncement(
                                            announcement.id
                                        )
                                    "
                                    class="cursor-pointer dark:bg-[#6084FF] bg-[#3B5FBF] outline-2 dark:outline-[#6084FF] outline-[#3B5FBF] py-3 px-4 rounded-xl hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] hover:outline-[#2F4C99] hover:dark:outline-[#4D6ACC] text-[#3B5FBF]"
                                >
                                    <i
                                        class="fa-solid fa-pen text-[#EEEEEE]"
                                    ></i>
                                </button>
                                <button
                                    @click="openDeleteModal(announcement.id)"
                                    class="cursor-pointer outline-2 dark:outline-[#6084FF] outline-[#3B5FBF] py-3 px-4 rounded-xl hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] hover:dark:outline-[#4D6ACC] hover:outline-[#2F4C99] text-[#3B5FBF] dark:text-[#6084FF] hover:text-[#EEEEEE]"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <DeleteConfirmation
        :id="announcementId"
        :title="'Delete Announcement!'"
        :message="'Are you sure you want to delete this announcement?'"
        :show="showDeleteConfirmation"
        :type="'announcement'"
        @close="closeDeleteModal"
    />
</template>
