<script setup lang="ts">
import { onMounted } from "vue";

// Import des composants
import graphPuffTemps from "./graphPuffTemps.vue";
import graphVolumeTemps from "./graphVolumeTemps.vue";
import graphNicoTemps from "./graphNicoTemps.vue";

// Import des variables et de la fonction depuis le fichier partagé
import {
    labelsDates,
    dataPuffs,
    dataVolume,
    dataClope,
    dataNico,
    dataManque,
    dataArgent,
    chargerDonneeGraph,
} from "./scripts/useGraph.ts";

const props = defineProps(["idUser"]);

onMounted(() => {
    // On passe directement l'ID de la prop
    chargerDonneeGraph(props.idUser);
});
</script>

<template>
    <div class="dashboard-container">
        <graphPuffTemps
            :labels="labelsDates"
            :dataPuffs="dataPuffs"
            :dataManque="dataManque"
        />

        <graphVolumeTemps
            :labels="labelsDates"
            :dataVolume="dataVolume"
            :dataClope="dataClope"
        />

        <graphNicoTemps
            :labels="labelsDates"
            :dataNico="dataNico"
            :dataPuffs="dataPuffs"
        />
    </div>
</template>
