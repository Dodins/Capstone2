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
        class="py-2 px-2 dark:bg-[#3C4053] dark:text-[#EEEEEE] bg-[#DDE3E7] text-[#222831] rounded-[8px] border-none"
        v-model="model"
        ref="input"
    />
</template>
