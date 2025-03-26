<script setup>
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ProcessReportModal from "../Modal/ProcessReportModal.vue";

const props = defineProps({
    concern: Object,
    status: String,
});

// Check if the status allows processing
const canProcess = computed(() => {
    return !["resolved", "completed", "rejected"].includes(props.status);
});

// Format date to readable format
const formatDate = (dateString) => {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

const showProcessModal = ref(false);

const openProcessModal = () => {
    showProcessModal.value = true;
};

const closeProcessModal = () => {
    showProcessModal.value = false;
};
</script>

<template>
    <div class="border-3 dark:border-[#3C4053] border-[#DDE3E7] p-4 rounded-xl">
        <div class="flex w-full h-full gap-4 items-center">
            <!-- Profile Image -->
            <div
                class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-24 w-24 flex items-center justify-center overflow-hidden"
            >
                <img
                    v-if="concern.user?.avatar"
                    :src="concern.user.avatar"
                    :alt="concern.user?.name || 'User'"
                    class="h-full w-full object-cover"
                />
                <span v-else class="text-2xl">👤</span>
            </div>

            <!-- Content -->
            <div class="flex flex-col justify-between flex-1">
                <div class="flex justify-between">
                    <h1
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                    >
                        {{ concern.title || `Report #${concern.id}` }}
                    </h1>
                    <span
                        class="px-2 py-1 rounded-full text-xs"
                        :class="{
                            'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300':
                                status === 'new',
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300':
                                status === 'under_review',
                            'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300':
                                status === 'pending_action',
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                status === 'resolved',
                            'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300':
                                status === 'completed',
                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300':
                                status === 'rejected',
                        }"
                    >
                        {{ status.replace("_", " ") }}
                    </span>
                </div>
                <h1
                    class="dark:text-[#B0B0B0] text-[#4B5660] text-[16px] line-clamp-2"
                >
                    {{ concern.description || "No description provided" }}
                </h1>
                <div class="flex justify-between mt-1">
                    <div
                        class="flex items-center gap-1 dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                    >
                        <span>👤</span>
                        <span>{{ concern.user?.name || "Anonymous" }}</span>
                    </div>
                    <div
                        class="flex items-center gap-1 dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                    >
                        <span>🕒</span>
                        <span>{{ formatDate(concern.created_at) }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2">
                <PrimaryButton v-if="canProcess" @click="openProcessModal">
                    Process Report
                </PrimaryButton>
                <SecondaryButton> View Details </SecondaryButton>
            </div>
        </div>
    </div>

    <!-- Process Report Modal -->
    <ProcessReportModal
        v-if="showProcessModal"
        :concern="concern"
        :status="status"
        @close="closeProcessModal"
    />
</template>
