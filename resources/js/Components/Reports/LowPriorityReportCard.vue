<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    concern: Object,
    status: String,
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

const showViewModal = ref(false);

const openViewModal = () => {
    showViewModal.value = true;
};

const closeViewModal = () => {
    showViewModal.value = false;
};
</script>

<template>
    <div class="border-3 dark:border-[#3C4053] border-[#DDE3E7] p-4 rounded-xl">
        <div class="flex w-full h-full gap-4 items-center">
            <div
                class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-24 w-24 flex items-center justify-center"
            >
                <span class="text-2xl">📝</span>
            </div>
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
                                props.status === 'new',
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300':
                                props.status === 'under_review',
                            'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300':
                                props.status === 'pending_action',
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                props.status === 'resolved',
                            'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300':
                                props.status === 'completed',
                        }"
                    >
                        {{ props.status.replace("_", " ") }}
                    </span>
                </div>
                <h1
                    class="dark:text-[#B0B0B0] text-[#4B5660] text-[16px] line-clamp-2"
                >
                    {{ concern.description || "No description provided" }}
                </h1>
                <div class="flex justify-between">
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Reported by: {{ concern.user?.name || "Anonymous" }}
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        {{ formatDate(concern.created_at) }}
                    </h1>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <PrimaryButton @click="openViewModal"> View </PrimaryButton>
                <SecondaryButton> Update </SecondaryButton>
            </div>
        </div>
    </div>
    <!-- You can add a modal component here similar to AcceptReport in your example -->
</template>
