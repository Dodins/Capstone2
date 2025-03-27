<script setup>
import { ref, onMounted, nextTick } from "vue";
import axios from "axios";

const props = defineProps({
    residents: Array,
});
</script>

<template>
    <div class="h-full w-full">
        <div
            class="overflow-y-auto no-scrollbar flex-grow min-h-0 max-h-[calc(100vh-590px)]"
        >
            <table class="table-fixed w-full">
                <thead class="sticky top-0 dark:bg-[#3C4053] bg-[#DDE3E7]">
                    <tr>
                        <th
                            class="w-1/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px]"
                        >
                            •
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Name
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Email
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Contact No.
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="resident in residents" :key="residents.id">
                        <td
                            class="mb-2 flex-1 items-center flex justify-center h-full"
                        >
                            <div
                                class="bg-[#EEEEEE] rounded-full w-8 h-8 flex justify-center item-center"
                            >
                                <i
                                    class="text-4xl fa-solid fa-circle-user dark:text-[#6084FF] text-[#3B5FBF]"
                                ></i>
                            </div>
                        </td>
                        <td
                            class="mb-2 truncate max-w-[200px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px] font-bold"
                        >
                            {{ resident.full_name }}
                        </td>
                        <td
                            class="mb-2 truncate max-w-[250px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px]"
                        >
                            {{ resident.email }}
                        </td>
                        <td
                            class="mb-2 truncate max-w-[150px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px]"
                        >
                            {{ resident.phone_number }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
