<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AcceptReport from "../Modal/AcceptReport.vue";

const props = defineProps({
    title: String,
    incomingConcerns: Array,
});

const showAcceptConfirmation = ref(false);

const openAcceptModal = (id) => {
    showAcceptConfirmation.value = true;
};

const closeDeleteModal = () => {
    showAcceptConfirmation.value = false;
};
</script>

<template>
    <div class="border-3 dark:border-[#3C4053] border-[#DDE3E7] p-4 rounded-xl">
        <div class="flex w-full h-full gap-4 items-center">
            <div
                class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-24 w-24"
            ></div>
            <div class="flex flex-col justify-between flex-1">
                <h1
                    class="w-1/4 dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                >
                    {{ props.title }}
                </h1>
                <h1
                    class="w-2/4 dark:text-[#B0B0B0] text-[#4B5660] text-[16px]"
                >
                    hahahahhahahahah
                    hehehehehehehehehehehehehehehehehehehehehehe
                </h1>
                <h1
                    class="w-1/4 dark:text-[#B0B0B0] text-[#4B5660] text-[16px]"
                >
                    January 1, 2025
                </h1>
            </div>
            <div class="flex flex-col gap-2">
                <PrimaryButton @click="openAcceptModal"> Accept </PrimaryButton>
                <SecondaryButton> Reject </SecondaryButton>
            </div>
        </div>
    </div>
    <AcceptReport
        :show="showAcceptConfirmation"
        @close="closeDeleteModal"
    />
</template>
