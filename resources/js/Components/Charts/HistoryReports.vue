<script setup>
import { ref, computed, onMounted } from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    TimeScale,
} from "chart.js";
import { Bar } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";
import "chartjs-adapter-date-fns"; // For date formatting

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    TimeScale,
    ChartDataLabels
);

const props = defineProps({
    reportData: {
        type: Array,
        default: () => [],
    },
});

const isDarkMode = ref(false);
const isLoading = ref(true);
const dailyReports = ref([]);

// Check for dark mode
const checkDarkMode = () => {
    isDarkMode.value = document.documentElement.classList.contains("dark");
};

// Fetch data from the controller
const fetchDailyReports = async () => {
    try {
        isLoading.value = true;
        const response = await fetch("/daily-reports");
        const data = await response.json();
        dailyReports.value = data;
    } catch (error) {
        console.error("Error fetching daily reports:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    checkDarkMode();

    // Set up dark mode observer
    const observer = new MutationObserver(checkDarkMode);
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"],
    });

    // If reportData is provided as a prop, use it, otherwise fetch data
    if (props.reportData && props.reportData.length > 0) {
        dailyReports.value = props.reportData;
        isLoading.value = false;
    } else {
        fetchDailyReports();
    }
});

// Create gradient for chart bars
const chartColors = computed(() => {
    return isDarkMode.value ? "#6084FF" : "#3B5FBF"; // Solid color, no gradient
});

const createGradient = (ctx, startColor, midColor, endColor) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, startColor);
    gradient.addColorStop(0.5, midColor);
    gradient.addColorStop(1, endColor);
    return gradient;
};

// Format dates for display
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", { month: "short", day: "numeric" });
};

// Prepare chart data
const chartData = computed(() => {
    if (!dailyReports.value.length) return { labels: [], datasets: [] };

    return {
        labels: dailyReports.value.map((item) => formatDate(item.date)),
        datasets: [
            {
                label: "Daily Reports",
                backgroundColor: chartColors.value,
                borderRadius: 4,
                data: dailyReports.value.map((item) => item.count),
                categoryPercentage: 0.9,
                barPercentage: 0.8,
            },
        ],
    };
});

// Chart options
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
                maxRotation: 45,
                minRotation: 45,
                autoSkip: true,
                maxTicksLimit: 20,
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
                precision: 0, // Only show whole numbers
            },
        },
    },
    plugins: {
        legend: {
            display: false,
        },
        datalabels: {
            color: "#EEEEEE",
            align: "center",
            anchor: "end",
            font: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "bold",
            },
            formatter: (value) => (value > 0 ? value : ""),
        },
        tooltip: {
            enabled: true,
            callbacks: {
                title: (tooltipItems) => {
                    const index = tooltipItems[0].dataIndex;
                    return dailyReports.value[index]?.date;
                },
                label: (context) => {
                    return `Reports: ${context.raw}`;
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
        },
    },
}));
</script>

<template>
    <div
        class="chart-container"
        style="position: relative; height: 100%; width: 100%"
    >
        <div v-if="isLoading" class="loading-overlay">
            <div class="loading-spinner"></div>
            <p>Loading data...</p>
        </div>

        <Bar
            v-else
            :data="chartData"
            :options="chartOptions"
            :style="{ height: '100%', width: '100%' }"
        />
    </div>
</template>

<style scoped>
.chart-container {
    position: relative;
    min-height: 300px;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.7);
}

.dark .loading-overlay {
    background-color: rgba(30, 30, 30, 0.7);
    color: #b0b0b0;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top-color: #3b5fbf;
    animation: spin 1s ease-in-out infinite;
    margin-bottom: 10px;
}

.dark .loading-spinner {
    border: 4px solid rgba(255, 255, 255, 0.1);
    border-top-color: #6084ff;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
