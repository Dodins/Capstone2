<script setup>
import { ref } from "vue";
import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler,
} from "chart.js";

// Register required Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler
);

// Chart Data
const chartData = ref({
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
    datasets: [
        {
            label: "Sales",
            data: [30, 50, 40, 60, 70, 65, 80],
            borderColor: "#3B82F6",
            backgroundColor: "rgba(59, 130, 246, 0.4)",
            fill: true,
            tension: 0.4,
        },
    ],
});

// Chart Options
const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
        },
    },
    scales: {
        x: {
            grid: {
                display: false,
            },
        },
        y: {
            beginAtZero: true,
        },
    },
});
</script>

<template>
    <Line
        :data="chartData"
        :options="chartOptions"
        :style="{ height: '100%', width: '100%' }"
    />
</template>
