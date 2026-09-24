<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import Chart from "chart.js/auto";

const props = defineProps<{
    labels: string[];
    dataVolume: number[];
    dataClope: number[];
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: Chart | null = null;

onMounted(() => {
    if (canvasRef.value) {
        chartInstance = new Chart(canvasRef.value, {
            type: "line",
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Volume (ml)",
                        data: [],
                        borderColor: "#b612fb",
                        backgroundColor: "rgba(66, 184, 131, 0.2)",
                        tension: 0.4,
                        fill: false,
                        yAxisID: "y",
                    },
                    {
                        label: "Cigarette Fumées",
                        data: [],
                        borderColor: "#42b883",
                        backgroundColor: "rgba(182, 18, 251, 0.2)",
                        tension: 0.2,
                        fill: false,
                        yAxisID: "y1",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y1: {
                        type: "linear",
                        display: true,
                        position: "left",
                    },
                    y: {
                        type: "linear",
                        display: true,
                        position: "right",
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                },
            },
        });
    }
});

watch(
    () => props.dataVolume,
    () => {
        if (chartInstance) {
            chartInstance.data.labels = props.labels;
            chartInstance.data.datasets[0] &&
                (chartInstance.data.datasets[0].data = props.dataVolume as any);
            chartInstance.data.datasets[1] &&
                (chartInstance.data.datasets[1].data = props.dataClope as any);
            chartInstance.update();
        }
    },
    { deep: true },
);
</script>

<template>
    <div style="width: 600px; height: 400px">
        <canvas ref="canvasRef"></canvas>
    </div>
</template>
