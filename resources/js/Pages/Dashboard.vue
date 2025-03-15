<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IncidentStatusOverview from "@/Components/IncidentStatusOverview.vue";
import DashboardHighReport from "@/Components/Reports/DashboardHighReport.vue";
import DashboardMediumReport from "@/Components/Reports/DashboardMediumReport.vue";
import DashboardLowReport from "@/Components/Reports/DashboardLowReport.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Dashboard</h2>
        </template>

        <div class="h-full w-full flex gap-4">
            <div class="w-full h-full flex flex-col gap-4">
                <div class="w-full h-1/3 flex gap-4">
                    <DashboardHighReport />
                    <DashboardMediumReport />
                    <DashboardLowReport />
                </div>
                <div
                    class="w-full h-full rounded-[16px] dark:bg-[#3C4053] bg-[#DDE3E7]"
                ></div>
                <div
                    class="w-full h-2/3 rounded-[16px] dark:bg-[#3C4053] bg-[#DDE3E7]"
                ></div>
            </div>
            <div class="w-1/3 flex flex-col gap-4">
                <div
                    class="h-1/2 flex-1 flex-col flex rounded-[16px] dark:bg-[#3C4053] bg-[#DDE3E7]"
                >
                    <div class="flex justify-between items-center mx-6 mt-6">
                        <h3
                            class="text-xl font-semibold dark:text-[#EEEEEE] text-[#222831]"
                            id="monthYear"
                        >
                            January 2025
                        </h3>
                        <div>
                            <button
                                id="prevMonth"
                                class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] mr-2"
                            >
                                &#x276E;
                            </button>
                            <button
                                id="nextMonth"
                                class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] ml-2"
                            >
                                &#x276F;
                            </button>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-7 gap-2 text-center text-xs dark:text-[#B0B0B0] text-[#4B5660] font-bold mt-3 mx-6"
                    >
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                    <div
                        id="calendarDays"
                        class="grid grid-cols-7 gap-2 text-center mt-2"
                    ></div>
                </div>
                <div
                    class="h-1/2 flex-1 flex-col flex rounded-[12px] dark:bg-[#3C4053] bg-[#DDE3E7]"
                >
                    <h1
                        class="text-[16px] dark:text-[#EEEEEE] text-[#222831] font-bold mx-6 mt-6"
                    >
                        Incident Status Overview
                    </h1>
                    <h1
                        class="text-[14px] dark:text-[#B0B0B0] text-[#4B5660] mx-6"
                    >
                        Incident Distribution by Current Status
                    </h1>
                    <div class="flex flex-1 flex-col">
                        <IncidentStatusOverview />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
