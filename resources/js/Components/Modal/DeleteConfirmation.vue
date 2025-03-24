<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    id: Number,
    title: String,
    message: String,
    show: Boolean,
    type: String,
});

const emit = defineEmits(["close", "deleted"]);

const close = () => {
    emit("close");
};

const confirmDelete = async () => {
    try {
        let apiUrl = "";
        if (props.type === "announcement") {
            apiUrl = `/announcement/destroy/${props.id}`;
        }
        if(props.type === "event"){
            apiUrl = `/calendar/destroy/${props.id}`;
        }
        if (!apiUrl) {
            console.error("Invalid type:", props.type);
            return;
        }
        emit("deleted", { id: props.id, type: props.type });
        await axios.delete(apiUrl);
        router.visit(window.location.href);
    } catch (e) {
        console.error(`Error deleting ${props.type}:`, e);
    }
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
    >
        <div
            class="dark:bg-[#3C4053] bg-[#DDE3E7] p-4 rounded-[6px] relative flex flex-col gap-12 border-t-4 dark:border-[#FF6666] border-[#FF4D4D]"
        >
            <div class="flex flex-col">
                <div
                    class="border-2 dark:border-[#FF6666] border-[#FF4D4D] w-10 h-10 rounded-full flex items-center justify-center"
                >
                    <i
                        class="fa-solid fa-trash dark:text-[#FF6666] text-[#FF4D4D]"
                    ></i>
                </div>
                <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold mt-4">
                    {{ title }}
                </h1>
                <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                    {{ message }}
                </h1>
            </div>
            <div class="flex justify-end items-center gap-4">
                <SecondaryButton class="text-[12px]" @click="close">
                    Cancel
                </SecondaryButton>
                <PrimaryButton class="text-[12px]" @click="confirmDelete">
                    Delete
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
