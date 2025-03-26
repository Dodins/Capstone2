<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    incomingConcerns: Object,
});

const selectedPriority = ref(null);

const setPriority = async (priority, id) => {
    console.log(priority, id);
    selectedPriority.value = priority;
};

const emit = defineEmits(["close"]);

const close = () => {
    emit("close");
};

const acceptConcern = async () => {
    if (!selectedPriority.value) {
        alert("Please select a priority level before accepting.");
        return;
    }
    try {
        await axios.post(
            route("setPriority", { id: props.incomingConcerns.id }),
            {
                priority: selectedPriority.value,
            }
        );
        close();
        router.visit(window.location.href);
    } catch (error) {
        console.error(
            "Error accepting concern:",
            error.response?.data || error
        );
    }
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
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                Select a priority level for "New Feature Request"
            </h1>
            <div class="flex flex-col gap-2 mt-4">
                <div
                    class="flex items-center border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl p-4 gap-4 hover:bg-[rgba(255,0,0,.2)] cursor-pointer"
                    @click="setPriority('high', props.incomingConcerns.id)"
                    :class="{
                        'bg-[rgba(255,0,0,.2)]': selectedPriority === 'high',
                        'hover:bg-[rgba(255,0,0,.2)]':
                            selectedPriority !== 'high',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(255,0,0,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-triangle-exclamation text-[#FF0000] text-[24px]"
                        ></i>
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
                    @click="setPriority('medium', props.incomingConcerns.id)"
                    :class="{
                        'bg-[rgba(255,193,7,.2)]':
                            selectedPriority === 'medium',
                        'hover:bg-[rgba(255,193,7,.2)]':
                            selectedPriority !== 'medium',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(255,193,7,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-exclamation-circle text-[#FFC107] text-[24px]"
                        ></i>
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
                    @click="setPriority('low', props.incomingConcerns.id)"
                    :class="{
                        'bg-[rgba(76,175,80,.2)]': selectedPriority === 'low',
                        'hover:bg-[rgba(76,175,80,.2)]':
                            selectedPriority !== 'low',
                    }"
                >
                    <div
                        class="w-12 h-12 bg-[rgba(76,175,80,.2)] rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-circle-info text-[#4CAF50] text-[24px]"
                        ></i>
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
                <PrimaryButton @click="acceptConcern">
                    Accept request
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
