<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IncidentStatusOverview from "@/Components/Charts/IncidentStatusOverview.vue";
import HistoryReports from "@/Components/Charts/HistoryReports.vue";
import DashboardHighReport from "@/Components/Reports/DashboardHighReport.vue";
import DashboardMediumReport from "@/Components/Reports/DashboardMediumReport.vue";
import DashboardLowReport from "@/Components/Reports/DashboardLowReport.vue";
import DashboardVerifiedUsers from "@/Components/Users/DashboardVerifiedUsers.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Dashboard</h2>
        </template>

        <div class="w-full h-full flex gap-4 pt-4">
            <div class="w-full h-full flex flex-col gap-4">
                <div class="flex gap-4 h-full w-full basis-64">
                    <div class="w-full bg-blue-500 rounded-2xl"></div>
                    <div class="w-full bg-green-500 rounded-2xl"></div>
                    <div class="w-full bg-red-500 rounded-2xl"></div>
                    <div class="w-full bg-green-500 rounded-2xl"></div>
                </div>
                <div
                    class="h-full w-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl"
                ></div>
                <div
                    class="h-full w-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl"
                ></div>
            </div>
            <div class="basis-128 h-full flex flex-col gap-4">
                <div
                    class="h-1/2 w-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl"
                ></div>
                <div
                    class="h-1/2 w-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl p-4"
                >
                    <div class="h-full w-full flex flex-col">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Incident Status Overview
                        </h1>
                        <h1 class="dark:text-[#B0B0B0] text-[#4B5660]">
                            Incident Distribution by Current Status
                        </h1>
                        <div class="h-full w-ful">
                            <IncidentStatusOverview />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
