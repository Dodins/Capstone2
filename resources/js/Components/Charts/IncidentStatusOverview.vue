<script setup>
import { ref, computed, onMounted } from "vue";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";
import { Doughnut } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";

ChartJS.register(Title, Tooltip, Legend, ArcElement, ChartDataLabels);

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

const chartColors = computed(() =>
    isDarkMode.value
        ? ["#FBC02D", "#1976D2", "#1B5E20", "#B71C1C"]
        : ["#FFAE00", "#2196F3", "#4CAF50", "#FF4D4D"]
);

const shadowPlugin = {
    id: "shadowEffect",
    beforeDraw: (chart) => {
        const ctx = chart.ctx;
        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            meta.data.forEach((element, index) => {
                ctx.save();
                const sliceColor = dataset.backgroundColor[index];
                ctx.shadowColor = sliceColor
                    .replace(")", ", 0.4)")
                    .replace("rgb", "rgba");
                ctx.shadowBlur = 29;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 9;
                element.draw(ctx);
                ctx.restore();
            });
        });
    },
};

const chartData = computed(() => ({
    labels: ["New", "Investigating", "Completed", "Rejected"],
    datasets: [
        {
            label: "Concern",
            backgroundColor: chartColors.value,
            borderColor: "transparent",
            borderRadius: 10,
            data: [50, 90, 120, 150],
        },
    ],
}));

const chartOptions = ref({
    cutout: "50%",
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: {
            top: 16,
            bottom: 16,
        },
    },
    plugins: {
        legend: {
            display: true,
            position: "left",
            align: "center",
            fullSize: false,
            labels: {
                usePointStyle: true,
                pointStyle: "circle",
                font: {
                    size: 12,
                    family: "'Quicksand', sans-serif",
                    weight: "bold",
                },
                color: computed(() =>
                    isDarkMode.value ? "#EEEEEE" : "#222831"
                ),
            },
        },
        datalabels: {
            color: (context) => {
                return context.dataset.backgroundColor[context.dataIndex];
            },
            backgroundColor: "rgba(255, 255, 255, 0.9)",
            borderRadius: 12,
            padding: {
                left: 16,
                right: 16,
                top: 10,
            },
            font: {
                family: "'Quicksand', sans-serif",
                size: 12,
                weight: "bold",
            },
            anchor: "end",
            align: "start",
            offset: -18,
            formatter: (value, context) => {
                const total = context.dataset.data.reduce(
                    (acc, val) => acc + val,
                    0
                );
                const percentage = (value / total) * 100;
                return percentage.toFixed(1) + "%";
            },
        },
        tooltip: {
            enabled: false,
        },
    },
});
</script>

<template>
    <Doughnut
        :data="chartData"
        :options="chartOptions"
        :plugins="[shadowPlugin]"
        :style="{ height: '100%', width: '100%' }"
    />
</template>
