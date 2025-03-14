<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Dashboard</h2>
        </template>

        <div class="h-full w-full flex gap-4">
            <div class="w-full bg-green-500"></div>
            <div class="grid grid-col gap-4">
                <div class="dark:bg-[#3C4053] bg-[#DDE3E7] rounded-[16px] p-4">
                    <h1
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                    >
                        Calendar
                    </h1>
                </div>
                <div class="dark:bg-[#3C4053] bg-[#DDE3E7] rounded-[16px] p-4">
                    <h1
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                    >
                        Incident status overview
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Incident Distribution by Current Status
                    </h1>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
