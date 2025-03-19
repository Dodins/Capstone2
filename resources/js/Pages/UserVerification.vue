<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VerificationRequestTable from "@/Components/Tables/VerificationRequestTable.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Verification" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">User verification</h2>
        </template>
        <div class="flex flex-col w-full h-full pt-4">
            <div class="h-1/10 flex justify-between items-center">
                <div class="px-4 py-2 rounded-2xl">
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Verification Request
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Review pending user submissions for approval.
                    </h1>
                </div>
                <div class="">
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Icon search
                    </h1>
                </div>
            </div>
            <div class="h-9/10 w-full pt-4">
                <VerificationRequestTable />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
