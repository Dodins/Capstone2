<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    icon: {
        type: Object,
        default: null,
    },
});

const classes = computed(() =>
    props.active
        ? "dark:bg-[#6084FF] bg-[#3B5FBF] py-4 mx-2 px-2 rounded-[16px] text-[#EEEEEE] font-bold text-[16px] flex items-center"
        : "py-4 px-2 mx-2 dark:text-[#B0B0B0] text-[#4B5660] flex items-center"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <component v-if="icon" :is="icon" class="w-6 h-6 me-2" />
        <slot />
    </Link>
</template>
