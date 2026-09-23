<script setup lang="ts">
//Import Vue et frameworkd
import { ref, onMounted } from "vue";
import Chart from "chart.js/auto";

//import type & fonction
import type { Relever } from "./script/Relever";
import { requeteAPI } from "./script/APIrequest";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

const canvaPuffTemps = ref<HTMLCanvasElement | null>(null);
const canvaVolumeTemps = ref<HTMLCanvasElement | null>(null);
const canvaArgentTemps = ref<HTMLCanvasElement | null>(null);

let graphiquePuffTemps: Chart | null = null;
let graphiqueVolumeTemps: Chart | null = null;
let graphiqueArgentTemps: Chart | null = null;

const chargerHistorique = async () => {
    const data = await requeteAPI("historique_releves", { id: id.value });

    if (data.resultat) {
        const historique = data.resultat as Relever[];

        const labelsDates = historique.map((releve) => releve.date_releve);
        const dataPuffs = historique.map((releve) => releve.puffs);
        const dataVolume = historique.map((releve) => releve.volume_ml);
        const dataDepense = historique.map((releve) => releve.depenses_euros);

        if (graphiquePuffTemps) {
            graphiquePuffTemps.data.labels = labelsDates;
            graphiquePuffTemps.data.datasets[0] &&
                (graphiquePuffTemps.data.datasets[0].data = dataPuffs as any);
            graphiquePuffTemps.update();
        }
        if (graphiqueVolumeTemps) {
            graphiqueVolumeTemps.data.labels = labelsDates;
            graphiqueVolumeTemps.data.datasets[0] &&
                (graphiqueVolumeTemps.data.datasets[0].data =
                    dataVolume as any);
            graphiqueVolumeTemps.update();
        }
        if (graphiqueArgentTemps) {
            graphiqueArgentTemps.data.labels = labelsDates;
            graphiqueArgentTemps.data.datasets[0] &&
                (graphiqueArgentTemps.data.datasets[0].data =
                    dataDepense as any);
            graphiqueArgentTemps.update();
        }
    }
};

onMounted(() => {
    if (canvaPuffTemps.value) {
        graphiquePuffTemps = new Chart(canvaPuffTemps.value, {
            type: "line",
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Puffs",
                        data: [],
                        borderColor: "#42b883",
                        backgroundColor: "rgba(66, 184, 131, 0.2)",
                        tension: 0.4,
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
    if (canvaVolumeTemps.value) {
        graphiqueVolumeTemps = new Chart(canvaVolumeTemps.value, {
            type: "line",
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Volume (ml)",
                        data: [],
                        borderColor: "#42b883",
                        backgroundColor: "rgba(66, 184, 131, 0.2)",
                        tension: 0.4,
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
    if (canvaArgentTemps.value) {
        graphiqueArgentTemps = new Chart(canvaArgentTemps.value, {
            type: "line",
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Argent dépensé (€)",
                        data: [],
                        borderColor: "#42b883",
                        backgroundColor: "rgba(66, 184, 131, 0.2)",
                        tension: 0.4,
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
    chargerHistorique();
});
</script>

<template>
    <button @click="chargerHistorique">button</button>

    <div style="width: 600px; height: 400px">
        <canvas ref="canvaPuffTemps"></canvas>
    </div>
    <div style="width: 600px; height: 400px">
        <canvas ref="canvaVolumeTemps"></canvas>
    </div>
    <div style="width: 600px; height: 400px">
        <canvas ref="canvaArgentTemps"></canvas>
    </div>
</template>
