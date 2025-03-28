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
import { ref, onMounted } from "vue";

const props = defineProps({
    residents: Array,
    residentCount: Number,
    crimeLocation: Array,
    concerns: Array,
    highConcerns: Number,
    mediumConcerns: Number,
    lowConcerns: Number,

    newConcerns: Number,
    investigatingConcerns: Number,
    completedConcerns: Number,
    rejectedConcerns: Number,
});

// References for pagination controls
const historyReportsRef = ref(null);
const prevPageBtn = ref(null);
const nextPageBtn = ref(null);
const chartData = ref([]);
const isExporting = ref(false);

// Handle pagination button clicks
const handlePrevPage = () => {
    if (historyReportsRef.value) {
        historyReportsRef.value.prevPage();
    }
};

const handleNextPage = () => {
    if (historyReportsRef.value) {
        historyReportsRef.value.nextPage();
    }
};

// Update button states based on pagination state
const updatePaginationButtons = (state) => {
    if (prevPageBtn.value) {
        prevPageBtn.value.disabled = !state.canGoPrev;
    }

    if (nextPageBtn.value) {
        nextPageBtn.value.disabled = !state.canGoNext;
    }
};

// Store chart data for export
const handleChartDataReady = (data) => {
    chartData.value = data;
};

// Export data to Excel
const exportToExcel = async () => {
    if (!chartData.value.length) {
        alert("No data available to export");
        return;
    }

    try {
        isExporting.value = true;

        // Dynamically import the xlsx library
        const XLSX = await import("xlsx");

        // Format data for Excel
        const data = chartData.value.map((item) => ({
            Date: item.formattedDate,
            "Number of Reports": item.count,
        }));

        // Create worksheet
        const worksheet = XLSX.utils.json_to_sheet(data);

        // Set column widths
        const columnWidths = [
            { wch: 15 }, // Date column
            { wch: 20 }, // Number of Reports column
        ];
        worksheet["!cols"] = columnWidths;

        // Create workbook
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Reports History");

        // Generate Excel file
        const excelBuffer = XLSX.write(workbook, {
            bookType: "xlsx",
            type: "array",
        });

        // Create Blob and download
        const blob = new Blob([excelBuffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        // Create download link
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = `Reports_History_${
            new Date().toISOString().split("T")[0]
        }.xlsx`;
        document.body.appendChild(link);
        link.click();

        // Clean up
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Error exporting to Excel:", error);
        alert("Failed to export data. Please try again.");
    } finally {
        isExporting.value = false;
    }
};

// Fallback export function if xlsx library fails to load
const exportToCsv = () => {
    if (!chartData.value.length) {
        alert("No data available to export");
        return;
    }

    // Create CSV content
    const headers = ["Date", "Number of Reports"];
    const csvRows = [
        headers.join(","),
        ...chartData.value.map(
            (item) => `"${item.formattedDate}",${item.count}`
        ),
    ];

    const csvContent = csvRows.join("\n");

    // Create Blob and download
    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = `Reports_History_${
        new Date().toISOString().split("T")[0]
    }.csv`;
    document.body.appendChild(link);
    link.click();

    // Clean up
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
};

onMounted(() => {
    // Initialize button references
    prevPageBtn.value = document.getElementById("prevPage");
    nextPageBtn.value = document.getElementById("nextPage");

    // Add click event listeners
    if (prevPageBtn.value) {
        prevPageBtn.value.addEventListener("click", handlePrevPage);
    }

    if (nextPageBtn.value) {
        nextPageBtn.value.addEventListener("click", handleNextPage);
    }
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
                <DashboardHighReport :highConcerns="props.highConcerns" />
                <DashboardMediumReport :mediumConcerns="props.mediumConcerns" />
                <DashboardLowReport :lowConcerns="props.lowConcerns" />
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
                                @click="exportToExcel"
                                :disabled="isExporting"
                                class="dark:bg-[#6084FF] bg-[#3B5FBF] text-[#EEEEEE] font-bold px-5 py-1 rounded-[6px] text-[13px] cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] disabled:opacity-70 disabled:cursor-wait flex items-center justify-center min-w-[80px]"
                            >
                                <span v-if="isExporting">Exporting...</span>
                                <span v-else>Export</span>
                            </button>
                            <div class="pagination-controls">
                                <button
                                    id="prevPage"
                                    disabled
                                    class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] mr-2 cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    &#x276E;
                                </button>
                                <button
                                    id="nextPage"
                                    class="text-[#EEEEEE] dark:bg-[#6084FF] bg-[#3B5FBF] py-1 px-3 rounded-[6px] mr-2 cursor-pointer hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    &#x276F;
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 mt-4">
                        <HistoryReports
                            ref="historyReportsRef"
                            :concerns="props.concerns"
                            @page-change="updatePaginationButtons"
                            @data-ready="handleChartDataReady"
                        />
                    </div>
                </div>
                <div
                    class="w-full h-2/5 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl p-4 flex flex-col overflow-hidden"
                >
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Verified users
                    </h1>
                    <VerifiedUsersTable :residents="props.residents" />
                </div>
            </div>
            <div class="w-2/6 h-full flex flex-col gap-4">
                <div
                    class="w-full h-1/2 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl overflow-hidden"
                >
                    <Map disableClicks :crimeLocation="props.crimeLocation" />
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
                        <IncidentStatusOverview
                            :newConcerns="newConcerns"
                            :investigatingConcerns="investigatingConcerns"
                            :completedConcerns="completedConcerns"
                            :rejectedConcerns="rejectedConcerns"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
