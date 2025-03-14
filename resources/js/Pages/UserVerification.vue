<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Verification" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">User verification</h2>
        </template>

        <div class="">You're logged in!</div>
    </AuthenticatedLayout>
</template>
