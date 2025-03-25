<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Low Priority Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Low Priority Reports</h2>
        </template>
    </AuthenticatedLayout>
</template>
