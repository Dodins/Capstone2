<script setup>
import { ref, computed, onMounted, watch } from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { Bar } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { parseISO, format, subDays, addDays } from "date-fns";

const props = defineProps({
    concerns: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["pageChange", "dataReady"]);

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ChartDataLabels
);

const isDarkMode = ref(false);
const currentPage = ref(0);
const daysPerPage = 5;
const allChartData = ref([]);

const checkDarkMode = () => {
    isDarkMode.value = document.documentElement.classList.contains("dark");
};

onMounted(() => {
    checkDarkMode();

    const observer = new MutationObserver(checkDarkMode);
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"],
    });

    // Initialize pagination state
    updatePaginationState();

    // Generate all chart data for export
    generateAllChartData();
});

// Calculate the total number of pages
const totalPages = computed(() => {
    if (!props.concerns.length) return 1;

    // Get the date range
    const dates = props.concerns.map((concern) =>
        format(parseISO(concern.created_at), "yyyy-MM-dd")
    );

    // Find earliest and latest dates
    const sortedDates = [...new Set(dates)].sort();
    if (sortedDates.length === 0) return 1;

    const earliestDate = new Date(sortedDates[0]);
    const latestDate = new Date(sortedDates[sortedDates.length - 1]);

    // Calculate total days in the range
    const dayDiff =
        Math.ceil((latestDate - earliestDate) / (1000 * 60 * 60 * 24)) + 1;

    // Calculate total pages
    return Math.ceil(dayDiff / daysPerPage);
});

// Generate data for all days (for export)
const generateAllChartData = () => {
    if (!props.concerns.length) {
        allChartData.value = [];
        return;
    }

    // Get all dates with concerns
    const concernDates = props.concerns.map((concern) =>
        format(parseISO(concern.created_at), "yyyy-MM-dd")
    );

    // Find earliest and latest dates
    const uniqueDates = [...new Set(concernDates)].sort();
    if (uniqueDates.length === 0) {
        allChartData.value = [];
        return;
    }

    const earliestDate = new Date(uniqueDates[0]);
    const latestDate = new Date(uniqueDates[uniqueDates.length - 1]);

    // Generate all days in the range
    const dayDiff =
        Math.ceil((latestDate - earliestDate) / (1000 * 60 * 60 * 24)) + 1;
    const allDays = Array.from({ length: dayDiff }, (_, i) =>
        format(addDays(earliestDate, i), "yyyy-MM-dd")
    );

    // Count concerns for each day
    const result = allDays.map((day) => {
        const count = props.concerns.filter(
            (concern) =>
                format(parseISO(concern.created_at), "yyyy-MM-dd") === day
        ).length;

        return {
            date: day,
            formattedDate: format(new Date(day), "MMM dd, yyyy"),
            count: count,
        };
    });

    allChartData.value = result;
    emit("dataReady", result);
};

// Handle page navigation
const nextPage = () => {
    if (currentPage.value < totalPages.value - 1) {
        currentPage.value++;
        updatePaginationState();
    }
};

const prevPage = () => {
    if (currentPage.value > 0) {
        currentPage.value--;
        updatePaginationState();
    }
};

// Update pagination state and emit to parent
const updatePaginationState = () => {
    emit("pageChange", {
        currentPage: currentPage.value,
        totalPages: totalPages.value,
        canGoNext: currentPage.value < totalPages.value - 1,
        canGoPrev: currentPage.value > 0,
    });
};

// Get all chart data for export
const getAllChartData = () => {
    return allChartData.value;
};

// Expose methods to parent component
defineExpose({
    nextPage,
    prevPage,
    getAllChartData,
});

const chartColors = computed(() => {
    const ctx = document.createElement("canvas").getContext("2d");

    return isDarkMode.value
        ? createGradient(ctx, "#6084FF", "#6084FF", "rgba(60, 64, 83, 0.5)")
        : createGradient(ctx, "#3B5FBF", "#3B5FBF", "rgba(221, 227, 231, 0.5)");
});

const createGradient = (ctx, startColor, midColor, endColor) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, startColor);
    gradient.addColorStop(0.5, midColor);
    gradient.addColorStop(1, endColor);
    return gradient;
};

const chartData = computed(() => {
    // If no concerns, return empty data
    if (!props.concerns.length) {
        return {
            labels: [],
            datasets: [
                {
                    label: "Concerns per Day",
                    data: [],
                    backgroundColor: chartColors.value,
                },
            ],
        };
    }

    // Get all dates with concerns
    const concernDates = props.concerns.map((concern) =>
        format(parseISO(concern.created_at), "yyyy-MM-dd")
    );

    // Find earliest and latest dates
    const uniqueDates = [...new Set(concernDates)].sort();
    if (uniqueDates.length === 0) {
        return {
            labels: [],
            datasets: [
                {
                    label: "Concerns per Day",
                    data: [],
                    backgroundColor: chartColors.value,
                },
            ],
        };
    }

    const earliestDate = new Date(uniqueDates[0]);

    // Calculate date range for current page
    const startOffset = currentPage.value * daysPerPage;
    const startDate = addDays(earliestDate, startOffset);

    // Generate days for current page
    const daysToShow = Array.from({ length: daysPerPage }, (_, i) =>
        format(addDays(startDate, i), "yyyy-MM-dd")
    );

    // Count concerns for each day
    const dailyConcernCounts = daysToShow.map((day) => {
        return props.concerns.filter(
            (concern) =>
                format(parseISO(concern.created_at), "yyyy-MM-dd") === day
        ).length;
    });

    return {
        labels: daysToShow.map((day) => format(new Date(day), "MMM dd")),
        datasets: [
            {
                label: "Concerns per Day",
                backgroundColor: chartColors.value,
                borderRadius: 4,
                data: dailyConcernCounts,
                categoryPercentage: 0.9,
                barPercentage: 1.0,
            },
        ],
    };
});

const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            grid: {
                display: false,
            },
            ticks: {
                color: isDarkMode.value ? "#B0B0B0" : "#4B5660",
                font: {
                    family: "'Quicksand', sans-serif",
                    size: 12,
                },
            },
        },
        y: {
            beginAtZero: true,
            ticks: {
                color: isDarkMode.value ? "#B0B0B0" : "#4B5660",
                font: {
                    family: "'Quicksand', sans-serif",
                    size: 12,
                },
            },
        },
    },
    plugins: {
        legend: {
            display: false,
        },
        datalabels: {
            color: "#EEEEEE",
            display: function (context) {
                return context.dataset.data[context.dataIndex] > 0;
            },
            align: "center",
            font: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "bold",
            },
        },
        tooltip: {
            enabled: true,
            callbacks: {
                title: (tooltipItems) => {
                    return tooltipItems[0].label;
                },
                label: (context) => {
                    return `Concerns: ${context.raw}`;
                },
            },
            titleFont: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "bold",
            },
            bodyFont: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "normal",
            },
            footerFont: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "normal",
            },
        },
    },
}));
</script>

<template>
    <Bar
        :data="chartData"
        :options="chartOptions"
        :style="{ height: '100%', width: '100%' }"
    />
</template>
