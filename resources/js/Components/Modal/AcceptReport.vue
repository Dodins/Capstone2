<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { updatePrimaryPalette } from "@primeuix/themes";
const props = defineProps({
    id: Number,
    show: Boolean,
});

const emit = defineEmits(["close"]);

const close = () => {
    emit("close");
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
    >
        <div class="w-128 dark:bg-[#3C4053] bg-[#DDE3E7] p-4 rounded-lg">
            <div class="w-full flex justify-between mb-4 items-center">
                <h1
                    class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                >
                    Accept Report
                </h1>
                <i
                    class="fa-solid fa-xmark dark:text-[#EEEEEE] text-[#222831] font-bold cursor-pointer"
                    @click="close"
                ></i>
            </div>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] font-bold">
                Set Priority Level
            </h1>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] mt-1 text-[14px]">
                Select a priority level for "New Feature Request"
            </h1>
            <div class="flex flex-col gap-2 mt-4">
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(255,0,0,.2)] cursor-pointer"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(255,0,0,.2)] rounded-full flex items-center justify-center"
                    >
                        <i class="fa-solid fa-arrow-up text-[#FF0000]"></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            High Priority
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            Critical issue requiring immediate attention.
                        </h1>
                    </div>
                </div>
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(255,193,7,.2)] cursor-pointer"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(255,193,7,.2)] rounded-full flex items-center justify-center"
                    >
                        <i class="fa-solid fa-arrow-right text-[#FFC107]"></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Medium Priority
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            Requires attention but not causing critical
                            features.
                        </h1>
                    </div>
                </div>
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(76,175,80,.2)] cursor-pointer"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(76,175,80,.2)] rounded-full flex items-center justify-center"
                    >
                        <i class="fa-solid fa-arrow-down text-[#4CAF50]"></i>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Low Priority
                        </h1>
                        <h1
                            class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                        >
                            Minimal impact, can be addressed during regular
                            hours.
                        </h1>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center mt-8 gap-2">
                <SecondaryButton @click="close"> Cancel </SecondaryButton>
                <PrimaryButton> Accept request </PrimaryButton>
            </div>
        </div>
    </div>
</template>
