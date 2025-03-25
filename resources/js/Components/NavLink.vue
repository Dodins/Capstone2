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
    iconSolid: {
        type: [Object, Function],
        default: null,
    },
    iconOutline: {
        type: [Object, Function],
        default: null,
    },
});

const classes = computed(() =>
    props.active
        ? "my-4 flex dark:text-[#6084FF] text-[#3B5FBF] w-full border-r-5 font-bold"
        : "my-4 dark:text-[#B0B0B0] text-[#4B5660] flex items-center"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <component :is="props.active ? iconSolid : iconOutline"
        class="w-6 h-6 me-2" />
        <slot />
    </Link>
</template>
