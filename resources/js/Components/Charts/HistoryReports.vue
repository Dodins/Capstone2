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
} from "chart.js";
import { Bar } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";

const props = defineProps({
    concerns: Array,
});

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

const chartData = computed(() => ({
    labels: ["Jan", "Feb", "Mar", "Apr", "May"],
    datasets: [
        {
            label: "Concern Status",
            backgroundColor: chartColors.value,
            borderRadius: 4,
            data: [50, 90, 120, 150, 50],
            categoryPercentage: 0.9,
            barPercentage: 1.0,
        },
    ],
}));

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
            align: "center",
            font: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "bold",
            },
        },
        tooltip: {
            enabled: true,
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
