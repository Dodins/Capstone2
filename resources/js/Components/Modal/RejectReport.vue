<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    show: Boolean,
    incomingConcerns: Object,
    rejectFunction: Function,
});

const selectedReason = ref(null);

const setReason = (reason) => {
    selectedReason.value = reason;
};

const emit = defineEmits(["close"]);

const close = () => {
    emit("close");
};

// Function that uses the original rejection method (currently in use)
const rejectConcern = async () => {
    if (!selectedReason.value) {
        alert("Please select a reason before rejecting.");
        return;
    }

    // Call the original rejection function passed from the parent
    await props.rejectFunction();
    close();
};

/*
// FUTURE IMPLEMENTATION: Uncomment this function when ready to track rejection reasons
// This function sends the selected reason to the backend, similar to how accept works
const rejectConcernWithReason = async () => {
    if (!selectedReason.value) {
        alert("Please select a reason before rejecting.");
        return;
    }
    try {
        // This would use a POST request to send the reason, similar to the accept function
        await axios.post(
            route("rejectIncomingReportsWithReason", { id: props.incomingConcerns.id }),
            {
                reason: selectedReason.value,
            }
        );
        close();
        router.visit(window.location.href);
    } catch (error) {
        console.error(
            "Error rejecting concern:",
            error.response?.data || error
        );
    }
};

// To use this function instead of the current one, replace the @click handler in the template:
// Change: @click="rejectConcern"
// To:     @click="rejectConcernWithReason"
*/
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        @click.self="close"
    >
        <div class="w-128 dark:bg-[#222831] bg-[#DDE3E7] p-4 rounded-lg">
            <div class="w-full flex justify-between mb-4 items-center">
                <h1
                    class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                >
                    Reject Report
                </h1>
                <i
                    class="fa-solid fa-xmark dark:text-[#EEEEEE] text-[#222831] font-bold cursor-pointer"
                    @click="close"
                ></i>
            </div>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] font-bold">
                Select Rejection Reason
            </h1>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                Please select a reason for rejecting this report
            </h1>
            <div class="flex flex-col gap-2 mt-4">
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(244,67,54,.2)] cursor-pointer"
                    @click="setReason('outside_jurisdiction')"
                    :class="{
                        'bg-[rgba(244,67,54,.2)]':
                            selectedReason === 'outside_jurisdiction',
                        'hover:bg-[rgba(244,67,54,.2)]':
                            selectedReason !== 'outside_jurisdiction',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(244,67,54,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-ban text-[#F44336] text-[24px]"
                        ></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Outside Jurisdiction
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            This issue is outside our area of responsibility or
                            authority.
                        </h1>
                    </div>
                </div>
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(33,150,243,.2)] cursor-pointer"
                    @click="setReason('insufficient')"
                    :class="{
                        'bg-[rgba(33,150,243,.2)]':
                            selectedReason === 'insufficient',
                        'hover:bg-[rgba(33,150,243,.2)]':
                            selectedReason !== 'insufficient',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(33,150,243,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-circle-info text-[#2196F3] text-[24px]"
                        ></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Insufficient Information
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            Not enough details provided to address the concern.
                        </h1>
                    </div>
                </div>
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(156,39,176,.2)] cursor-pointer"
                    @click="setReason('duplicate')"
                    :class="{
                        'bg-[rgba(156,39,176,.2)]':
                            selectedReason === 'duplicate',
                        'hover:bg-[rgba(156,39,176,.2)]':
                            selectedReason !== 'duplicate',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(156,39,176,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-copy text-[#9C27B0] text-[24px]"
                        ></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Duplicate Report
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            This issue has already been reported and is being
                            addressed.
                        </h1>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center mt-8 gap-2">
                <SecondaryButton @click="close"> Cancel </SecondaryButton>
                <PrimaryButton
                    @click="rejectConcern"
                    class="bg-[#F44336] hover:bg-[#D32F2F]"
                >
                    Reject report
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
