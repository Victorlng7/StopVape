<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import Chart from "chart.js/auto";

const props = defineProps<{
    labels: string[];
    dataNico: number[];
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
                        label: "Nico temps",
                        data: [],
                        borderColor: "#42b883",
                        backgroundColor: "rgba(66, 184, 131, 0.2)",
                        tension: 0.1,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    }
});

watch(
    () => props.dataNico,
    () => {
        if (chartInstance) {
            chartInstance.data.labels = props.labels;
            chartInstance.data.datasets[0] &&
                (chartInstance.data.datasets[0].data = props.dataNico as any);
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
