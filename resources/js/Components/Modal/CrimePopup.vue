<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    location: Object,
});

const confirmDelete = async () => {
    try {
        let apiUrl = route("map.destroy", {id: props.location.id});
        await axios.delete(apiUrl);
        router.visit(window.location.href);
    } catch (e) {
        console.error(`Error deleting:`, e);
    }
};

</script>

<template>
    <div
        class="rounded-xl dark:bg-[#3C4053] bg-[#DDE3E7] p-4 mb-2 w-72 gap-8 flex flex-col"
    >
        <div>
            <h1
                class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[16px]"
            >
                Crime Location
            </h1>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                Incident Location Details.
            </h1>
            <img
                :src="`${props.location.image}`"
                alt=""
                class="h-40 w-full my-4 rounded-xl dark:bg-[#2C2F40] bg-[#EAEFF2]"
            />
            <h1
                class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[16px]"
            >
                {{ props.location.name }}
            </h1>
            <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                {{ props.location.description }}
            </h1>
        </div>
        <SecondaryButton
            class="flex justify-center items-center gap-2 dark:outline-[#FF6666] dark:text-[#FF6666] hover:dark:bg-[#FF6666] hover:dark:outline-[#FF6666] outline-[#FF4D4D] text-[#FF4D4D] hover:bg-[#FF4D4D] hover:outline-[#FF4D4D]"
            @click="confirmDelete"
        >
            <i class="fa-solid fa-trash"></i>
            <h1 class="text-[12px]">Delete</h1>
        </SecondaryButton>
    </div>
</template>
