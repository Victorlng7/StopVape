<script setup lang="ts">
import { onMounted } from "vue";
import Total from "./Total.vue";
import Moyenne from "./Moyenne.vue";

// On importe les variables et la fonction depuis notre nouveau fichier
import {
    labelsDates,
    dataPuffs,
    dataVolume,
    dataClope,
    dataNico,
    dataArgent,
    chargerDonneeStats,
} from "./scripts/useStats.ts";

onMounted(() => {
    chargerDonneeStats();
});
</script>

<template>
    <Total
        :labels="labelsDates"
        :dataPuffs="dataPuffs"
        :dataNico="dataNico"
        :dataVolume="dataVolume"
        :dataClope="dataClope"
        :dataArgent="dataArgent"
    />
    <Moyenne
        :labels="labelsDates"
        :dataPuffs="dataPuffs"
        :dataNico="dataNico"
        :dataVolume="dataVolume"
        :dataClope="dataClope"
        :dataArgent="dataArgent"
    />
</template>
