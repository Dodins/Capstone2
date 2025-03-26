<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import PriorityReportCard from "../PriorityReportCard.vue";

const props = defineProps({
    concerns: Array,
});

const statuses = [
    { key: "new", label: "New" },
    { key: "under_review", label: "Under Review" },
    { key: "pending_action", label: "Pending Action" },
    { key: "resolved", label: "Resolved" },
    { key: "completed", label: "Completed" },
    { key: "rejected", label: "Rejected" },
];

// Get current status from URL
const currentStatus = computed(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");
    return statuses.some((s) => s.key === status) ? status : "new";
});

// Filter concerns based on current status
const filteredConcerns = computed(() => {
    if (!props.concerns) return [];
    return props.concerns;
});
</script>

<template>
    <div
        class="w-full flex flex-col gap-4 flex-grow min-h-0 max-h-[calc(100vh-239px)]"
    >
        <!-- Tabs -->
        <div class="border-b dark:border-[#3C4053] border-[#DDE3E7]">
            <div class="grid w-full grid-cols-6">
                <Link
                    v-for="status in statuses"
                    :key="status.key"
                    :href="`?status=${status.key}`"
                    class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 relative h-10"
                    :class="[
                        currentStatus === status.key
                            ? 'dark:text-[#EEEEEE] text-[#222831]'
                            : 'dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#EEEEEE] hover:text-[#222831]',
                    ]"
                >
                    {{ status.label }}
                    <span
                        v-if="currentStatus === status.key"
                        class="absolute bottom-0 left-0 right-0 h-0.5 dark:bg-[#EEEEEE] bg-[#222831]"
                    ></span>
                </Link>
            </div>
        </div>

        <!-- Reports List -->
        <div
            class="h-full w-full overflow-y-auto overflow-hidden flex-grow min-h-0 max-h-[calc(100vh-239px)] no-scrollbar"
        >
            <div v-if="filteredConcerns.length > 0">
                <ul class="space-y-4">
                    <li v-for="concern in filteredConcerns" :key="concern.id">
                        <PriorityReportCard
                            :concern="concern"
                            :status="currentStatus"
                        />
                    </li>
                </ul>
            </div>
            <div v-else class="flex flex-col items-center justify-center h-64">
                <div
                    class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-16 w-16 flex items-center justify-center mb-4"
                >
                    <span class="text-2xl">📋</span>
                </div>
                <h1
                    class="dark:text-[#EEEEEE] text-[#222831] font-bold text-lg"
                >
                    No reports found
                </h1>
                <p class="dark:text-[#B0B0B0] text-[#4B5660] text-center mt-2">
                    There are no reports with the "{{
                        currentStatus.replace("_", " ")
                    }}" status.
                </p>
            </div>
        </div>
    </div>
</template>
