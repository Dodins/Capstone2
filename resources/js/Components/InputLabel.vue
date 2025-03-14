<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="dark:text-[#EEEEEE] text-[#222831] font-bold">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
