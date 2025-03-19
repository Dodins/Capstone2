<script setup>
import { defineProps, defineEmits } from "vue";

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
        <div class="bg-white rounded-lg p-4 max-w-lg w-full relative">
            <button
                @click="close"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
            >
                ✕
            </button>
            <img
                :src="imageSrc"
                alt="Resident Image"
                class="w-full h-auto rounded-lg"
            />
        </div>
    </div>
</template>
