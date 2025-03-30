<script setup>
import { ref, getCurrentInstance } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AcceptReport from "../Modal/AcceptReport.vue";
import RejectReport from "../Modal/RejectReport.vue";
import ImageView from "../Modal/ImageView.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    title: String,
    incomingConcerns: Object,
});

const { proxy } = getCurrentInstance();
const hostUrl = proxy.$hostUrl;
const selectedImage = ref(null);
const showAcceptConfirmation = ref(false);
const showRejectConfirmation = ref(false);

const openAcceptModal = () => {
    showAcceptConfirmation.value = true;
};

const openRejectModal = () => {
    showRejectConfirmation.value = true;
};

const closeAcceptModal = () => {
    showAcceptConfirmation.value = false;
};

const closeRejectModal = () => {
    showRejectConfirmation.value = false;
};

const openImageView = (imageUrl) => {
    selectedImage.value = `${hostUrl}/${imageUrl}`;
};

// Original rejection function
const rejectIncomingReport = async () => {
    console.log(props.incomingConcerns.id);
    try {
        await axios.delete(
            route("rejectIncomingReports", { id: props.incomingConcerns.id })
        );
        router.visit(window.location.href);
    } catch (error) {
        console.error("Error accepting concern:", error);
    }
};
</script>

<template>
    <div class="border-3 dark:border-[#3C4053] border-[#DDE3E7] p-4 rounded-xl">
        <div class="flex w-full h-full gap-4 items-center">
            <div
                class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] h-24 w-24"
                @click="openImageView(props.incomingConcerns.evidence)"
            >
                <img
                    :src="props.incomingConcerns.evidence"
                    alt="Evidence Image"
                    class="h-full w-full object-cover rounded-xl"
                />
            </div>
            <div class="flex flex-col justify-between flex-1">
                <h1
                    class="w-1/4 dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                >
                    {{ props.incomingConcerns.location }}
                </h1>
                <h1
                    class="w-2/4 dark:text-[#B0B0B0] text-[#4B5660] text-[16px]"
                >
                    {{ props.incomingConcerns.description }}
                </h1>
                <h1
                    class="w-1/4 dark:text-[#B0B0B0] text-[#4B5660] text-[16px]"
                >
                    {{ props.incomingConcerns.formatted_date }}
                </h1>
            </div>
            <div class="flex flex-col gap-2">
                <PrimaryButton @click="openAcceptModal"> Accept </PrimaryButton>
                <SecondaryButton @click="openRejectModal">
                    Reject
                </SecondaryButton>
            </div>
        </div>
    </div>
    <AcceptReport
        :show="showAcceptConfirmation"
        @close="closeAcceptModal"
        :incomingConcerns="props.incomingConcerns"
    />
    <RejectReport
        :show="showRejectConfirmation"
        @close="closeRejectModal"
        :incomingConcerns="props.incomingConcerns"
        :rejectFunction="rejectIncomingReport"
    />
    <ImageView
        v-if="selectedImage"
        :imageSrc="selectedImage"
        :show="!!selectedImage"
        @close="selectedImage = null"
    />
</template>
