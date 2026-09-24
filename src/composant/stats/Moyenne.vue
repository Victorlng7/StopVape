<script setup lang="ts">
//Import vue
import { ref, watch } from "vue";

//Import composant

//import interface / API

const props = defineProps<{
    labels: string[];
    dataPuffs: number[];
    dataNico: number[];
    dataVolume: Number[];
    dataClope: number[];
}>();

watch(
    () => props.dataPuffs,
    () => {
        //fonction
    },
    { deep: true },
);
</script>

<template></template>
