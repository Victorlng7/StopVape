<script setup lang="ts">
//Import vue
import { ref, watch } from "vue";

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

watch(
    () => props.dataPuffs,
    () => {
        // console.log({
        //     labels: props.labels,
        //     dataPuffs: props.dataPuffs,
        //     dataNico: props.dataNico,
        //     dataVolume: props.dataVolume,
        //     dataClope: props.dataClope,
        // });

        s.setLabel(props.labels);
        s.setPuff(props.dataPuffs);
        s.setNico(props.dataNico);
        s.setVolume(props.dataVolume);
        s.setClope(props.dataClope);

        // display();
    },
    { deep: true },
);

function display() {
    console.log({
        label: s.label,
        puff: s.puff,
        nico: s.nico,
        clope: s.clope,
        volume: s.volume,
        totalPuff: s.totalPuff,
        totalClope: s.totalClope,
        totalVolume: s.totalVolume,
        tempsSevrage: s.tempsSevrage,
    });
}
</script>

<template></template>
