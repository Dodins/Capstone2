<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="py-2 px-2 dark:text-[#EEEEEE] text-[#222831] rounded-[8px] focus:outline-none"
        v-model="model"
        ref="input"
    />
</template>
