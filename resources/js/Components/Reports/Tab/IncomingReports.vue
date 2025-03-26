<script setup>
import IncomingReportCard from "@/Components/Reports/IncomingReportCard.vue";

const props = defineProps({
    incomingConcerns: Array,
});

const items = ["Item 1", "Item 2", "Item 3", "Item 4", "Item 5"];
</script>

<template>
    <div
        class="h-full w-full overflow-y-auto overflow-hidden flex-grow min-h-0 max-h-[calc(100vh-239px)] no-scrollbar"
    >
        <div v-if="incomingConcerns.length > 0">
            <ul class="space-y-4">
                <li
                    v-for="incomingConcern in props.incomingConcerns"
                    :key="incomingConcern.id"
                >
                    <IncomingReportCard :incomingConcerns="incomingConcern" />
                </li>
            </ul>
        </div>
        <div
            v-else
            class="flex-col w-full h-full flex items-center justify-center"
        >
            <div
                class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-16 w-16 flex items-center justify-center mb-4"
            >
                <span class="text-2xl">📋</span>
            </div>
            <h1 class="font-bold dark:text-[#EEEEEE] text-[#222831]">
                No incoming reports found.
            </h1>
        </div>
    </div>
</template>
