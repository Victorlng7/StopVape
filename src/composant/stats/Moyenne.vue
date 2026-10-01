<script setup lang="ts">
//Import vue
import { ref, watch } from "vue";

//Import composant

//import interface / API
import Stats from "./Stats.vue";
import { stats } from "./scripts/classStats";
import { moyenne } from "./scripts/classMoyenne.ts";

const props = defineProps<{
    labels: string[];
    dataPuffs: number[];
    dataNico: number[];
    dataVolume: number[];
    dataClope: number[];
    dataArgent: number[];
}>();

const s = new stats();
const m = new moyenne();

const argentTemps = ref(0);
const puffTemps = ref(0);
const puffVolume = ref(0);

watch(
    () => props.dataPuffs,
    () => {
        s.setLabel(props.labels);
        s.setPuff(props.dataPuffs);
        s.setNico(props.dataNico);
        s.setVolume(props.dataVolume);
        s.setClope(props.dataClope);

        m.setDuree(s.tempsSevrage);
        m.setArgent(s.totalArgent);
        m.setPuff(s.totalPuff);
        m.setVolume(s.totalVolume);

        assignerValeur();
    },
    { deep: true },
);

function assignerValeur() {
    argentTemps.value = m.argentTemps;
    puffTemps.value = m.puffTemps;
    puffVolume.value = m.puffVolume;
}
</script>

<template>
    <p>Argent / jours : {{ argentTemps }}</p>
    <p>Puff / jours : {{ puffTemps }}</p>
    <p>Volume / puff (ml) : {{ puffVolume }}</p>
</template>
