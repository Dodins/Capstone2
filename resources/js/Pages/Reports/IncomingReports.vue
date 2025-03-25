<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    incomingConcerns: Array,
});
</script>

<template>
    <Head title="Incoming Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Incoming Reports</h2>
        </template>
    </AuthenticatedLayout>
</template>
