<script setup lang="ts">
//Import vue
import { ref, onMounted } from "vue";

//Import composant
import graphPuffTemps from "./graphPuffTemps.vue";
import graphVolumeTemps from "./graphVolumeTemps.vue";
import graphNicoTemps from "./graphNicoTemps.vue";

//import interface / API
import { chargerHistorique } from "../chargerHistorique.ts";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

// Variables réactives pour stocker les données découpées
const labelsDates = ref<string[]>([]);
const dataPuffs = ref<number[]>([]);
const dataVolume = ref<number[]>([]);
const dataClope = ref<number[]>([]);
const dataNico = ref<number[]>([]);
const dataManque = ref<number[]>([]);
const dataArgent = ref<number[]>([]);

onMounted(() => {
    chargerDonnee();
});

const chargerDonnee = async () => {
    const historique = await chargerHistorique(id.value);

    if (historique) {
        labelsDates.value = historique.map((r) => r.date_releve);
        dataPuffs.value = historique.map((r) => r.puffs);
        dataVolume.value = historique.map((r) => r.volume_ml);
        dataClope.value = historique.map((r) => r.cigarettes_fumees);
        dataNico.value = historique.map((r) => r.taux_nicotine);
        dataArgent.value = historique.map((r) => r.depenses_euros);
    }
};
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
