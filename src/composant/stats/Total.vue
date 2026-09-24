<script setup lang="ts">
//Import vue
import { ref, watch, toRaw } from "vue";

//Import composant

//import function
import { stats } from "./scripts/classStats";

const props = defineProps<{
    labels: string[];
    dataPuffs: number[];
    dataNico: number[];
    dataVolume: number[];
    dataClope: number[];
}>();

const s = new stats([], [], [], [], []);

const totalPuff = ref(0);
const totalClope = ref(0);
const totalVolume = ref(0);
const tempsSevrage = ref(0);
watch(
    () => props.dataPuffs,
    () => {
        s.setLabel(props.labels);
        s.setPuff(props.dataPuffs);
        s.setNico(props.dataNico);
        s.setVolume(props.dataVolume);
        s.setClope(props.dataClope);

        assignerValeur();
    },
    { deep: true },
);

function assignerValeur() {
    // Valeurs retourné par la classe :
    //     label: s.label,
    //     puff: s.puff,
    //     nico: s.nico,
    //     clope: s.clope,
    //     volume: s.volume,
    //     totalPuff: s.totalPuff,
    //     totalClope: s.totalClope,
    //     totalVolume: s.totalVolume,
    //     tempsSevrage: s.tempsSevrage,

    totalPuff.value = s.totalPuff;
    totalClope.value = s.totalClope;
    totalVolume.value = s.totalVolume;
    tempsSevrage.value = s.tempsSevrage;
}
</script>

<template>
    <p>total puff : {{ totalPuff }}</p>
    <p>total clope : {{ totalClope }}</p>
    <p>total volume : {{ totalVolume }}</p>
    <p>temps sevrage (jours) : {{ tempsSevrage }}</p>
</template>
