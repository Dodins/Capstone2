<script setup>
const props = defineProps({
    imageSrc: String,
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
        <div class="dark:bg-[#3C4053] bg-[#DDE3E7] p-4 rounded-lg relative">
            <button
                @click="close"
                class="absolute top-2 right-2 dark:text-[#EEEEEE] text-[#222831] hover:text-gray-900 cursor-pointer"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="mt-4">
                <img
                    :src="imageSrc"
                    alt="Resident Image"
                    class="w-[716px] h-[600px] rounded-lg"
                />
            </div>
        </div>
    </div>
</template>
