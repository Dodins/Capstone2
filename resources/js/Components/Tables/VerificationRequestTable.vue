<script setup>
import Checkbox from "@/Components/Checkbox.vue";
</script>

<template>
    <div class="h-full w-full">
        <div class="overflow-y-auto h-full no-scrollbar">
            <table class="table-fixed w-full max-h-full">
                <thead class="sticky top-0">
                    <tr>
                        <th
                            class="w-1/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-center rounded-tl-xl rounded-bl-xl dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            <Checkbox />
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Name
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Email
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Contact No.
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Emergency Contact No.
                        </th>
                        <th
                            class="w-3/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Address
                        </th>
                        <th
                            class="w-1/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Gender
                        </th>
                        <th
                            class="w-3/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Proof of IDs
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start rounded-tr-xl rounded-br-xl dark:bg-[#3C4053] bg-[#DDE3E7]"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="i in 100" :key="i">
                        <td
                            class="text-center py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            <Checkbox />
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Name asdasdasd aslkdjalskdjalksjdlaj lajksdlakjs
                            {{ i }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Email
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Contact No.
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Emergency Contact No.
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Address
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Gender
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] text-[#EEEEEE]"
                        >
                            <div
                                class="dark:bg-[#6084FF] bg-[#3B5FBF] rounded-full overflow-hidden whitespace-nowrap text-ellipsis py-1 px-2"
                            >
                                asdaskjdalksjdl aksjldajsldjk alsjd lasj dlasj
                                dlakjs dlasj dlka
                            </div>
                        </td>
                        <td
                            class="text-center py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831]"
                        >
                            <button
                                class="dark:text-[#6084FF] text-[#3B5FBF] text-[14px] me-2 font-bold hover:dark:text-[#4D6ACC] hover:text-[#2F4C99] cursor-pointer"
                            >
                                Accept
                            </button>
                            <button
                                class="dark:text-[#EEEEEE] text-[#222831] text-[14px] font-bold hover:dark:text-[#DDDDDD] hover:text-[#000000] cursor-pointer"
                            >
                                Reject
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
