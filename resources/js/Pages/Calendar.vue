<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Calendar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Calendar</h2>
        </template>
    </AuthenticatedLayout>
</template>
