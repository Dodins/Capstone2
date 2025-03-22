<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IncidentStatusOverview from "@/Components/Charts/IncidentStatusOverview.vue";
import Map from "@/Components/Map.vue";
import VerifiedUsersTable from "@/Components/Tables/VerifiedUsersTable.vue";
import HistoryReports from "@/Components/Charts/HistoryReports.vue";
import DashboardHighReport from "@/Components/Reports/DashboardHighReport.vue";
import DashboardMediumReport from "@/Components/Reports/DashboardMediumReport.vue";
import DashboardLowReport from "@/Components/Reports/DashboardLowReport.vue";
import DashboardVerifiedUsers from "@/Components/Reports/DashboardVerifiedUsers.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    residents: Array,
    residentCount: Number,
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Dashboard</h2>
        </template>

        <div class="flex gap-4 w-full h-full">
            <div class="flex flex-col gap-4 w-1/6 h-full">
                <DashboardHighReport />
                <DashboardMediumReport />
                <DashboardLowReport />
                <DashboardVerifiedUsers :residentCount="props.residentCount" />
            </div>
            <div class="w-3/6 h-full flex flex-col gap-4">
                <div
                    class="w-full h-3/5 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl p-4 flex flex-col"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <h1
                                class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                            >
                                History of reports
                            </h1>
                            <h1
                                class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                            >
                                Report resolution time
                            </h1>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="dark:bg-[#6084FF] bg-[#3B5FBF] text-[#EEEEEE] font-bold px-5 py-1 rounded-[6px] text-[13px] cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99]"
                            >
                                Export
                            </button>
                            <div class="pagination-controls">
                                <button
                                    id="prevPage"
                                    disabled
                                    class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] mr-2 cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99]"
                                >
                                    &#x276E;
                                </button>
                                <button
                                    id="nextPage"
                                    class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] mr-2 cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99]"
                                >
                                    &#x276F;
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 mt-4">
                        <HistoryReports />
                    </div>
                </div>
                <div
                    class="w-full h-2/5 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl p-4 flex flex-col overflow-hidden"
                >
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Verified users
                    </h1>
                    <VerifiedUsersTable :residents="props.residents"/>
                </div>
            </div>
            <div class="w-2/6 h-full flex flex-col gap-4">
                <div
                    class="w-full h-1/2 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl overflow-hidden"
                >
                    <Map disableClicks />
                </div>
                <div
                    class="w-full h-1/2 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl flex flex-col p-4"
                >
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Incident Status Overview
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Incident Distribution by Current Status
                    </h1>

                    <div class="h-full w-full">
                        <IncidentStatusOverview />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
