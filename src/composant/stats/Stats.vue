<script setup lang="ts">
//Import vue
import { ref, onMounted, toRaw } from "vue";

//Import composant
import Total from "./Total.vue";
import Moyenne from "./Moyenne.vue";

//import interface / API
import type { Relever } from "../graphiques/scripts/Relever.ts";
import { requeteAPI } from "../APIrequest.ts";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

// Variables réactives pour stocker les données découpées
const labelsDates = ref<string[]>([]);
const dataPuffs = ref<number[]>([]);
const dataVolume = ref<number[]>([]);
const dataClope = ref<number[]>([]);
const dataNico = ref<number[]>([]);
const dataArgent = ref<number[]>([]);

const chargerHistorique = async () => {
    const data = await requeteAPI("historique_releves", { id: id.value });

    if (data.resultat) {
        const historique = data.resultat as Relever[];

        labelsDates.value = historique.map((r) => r.date_releve);
        dataPuffs.value = historique.map((r) => r.puffs);
        dataVolume.value = historique.map((r) => r.volume_ml);
        dataClope.value = historique.map((r) => r.cigarettes_fumees);
        dataNico.value = historique.map((r) => r.taux_nicotine);
        dataArgent.value = historique.map((r) => r.depenses_euros);
    }
};

onMounted(() => {
    chargerHistorique();
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
</template>
