<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="High Priority Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">High Priority Reports</h2>
        </template>
    </AuthenticatedLayout>
</template>
