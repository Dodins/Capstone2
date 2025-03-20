<script setup>
import { ref, onMounted, nextTick } from "vue";
import axios from "axios";

const announcements = ref([]);

for (let i = 1; i <= 12; i++) {
    announcements.value.push({
        id: i,
        title: `Barangay Clean-Up Drive Scheduled for This Weekend`,
        description: `Join us for a clean-up drive this Saturday, January 27, 2025, at 7:00 AM. Meet at the Barangay Hall. Gloves and cleaning supplies will be provided. Let's keep our community clean!`,
        date: `January 21, 2025`,
    });
}
</script>

<template>
    <div
        class="w-full dark:bg-[#3C4053] bg-[#DDE3E7] overflow-hidden rounded-xl"
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
                        v-for="announcement in announcements"
                        :key="announcement.id"
                    >
                        <td
                            class="w-3/10 pe-4 pb-4 pt-2 px-6 text-start align-top dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.title }}
                        </td>
                        <td
                            class="w-3/10 pe-4 pb-4 pt-2 px-6 text-start dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.description }}
                        </td>
                        <td
                            class="w-3/10 pe-4 pb-4 pt-2 px-6 align-top text-start dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ announcement.date }}
                        </td>
                        <td
                            class="w-1/10 pb-4 pt-2 text-center dark:text-[#EEEEEE] text-[#222831]"
                        >
                            <div class="flex gap-4 items-center justify-center">
                                <button
                                    class="dark:bg-[#6084FF] bg-[#3B5FBF] outline-2 dark:outline-[#6084FF] outline-[#3B5FBF] py-3 px-4 rounded-xl hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] hover:outline-[#2F4C99] hover:dark:outline-[#4D6ACC] text-[#3B5FBF]"
                                >
                                    <i
                                        class="fa-solid fa-pen text-[#EEEEEE]"
                                    ></i>
                                </button>
                                <button
                                    class="outline-2 dark:outline-[#6084FF] outline-[#3B5FBF] py-3 px-4 rounded-xl hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] hover:dark:outline-[#4D6ACC] hover:outline-[#2F4C99] text-[#3B5FBF] dark:text-[#6084FF] hover:text-[#EEEEEE]"
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
</template>
