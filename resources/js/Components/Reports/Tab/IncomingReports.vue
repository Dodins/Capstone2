<script setup>
import ReportCard from "../ReportCard.vue";

const props = defineProps({
    incomingConcerns: Array,
});

const items = ["Item 1", "Item 2", "Item 3", "Item 4", "Item 5"];
</script>

<template>
    <div
        class="h-full w-full overflow-y-auto overflow-hidden flex-grow min-h-0 max-h-[calc(100vh-239px)] no-scrollbar"
    >
        <ul class="space-y-4">
            <li v-for="(item, index) in items" :key="index">
                <ReportCard :title="item" />
            </li>
        </ul>
    </div>
</template>
