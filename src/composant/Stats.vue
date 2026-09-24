<script setup lang="ts">
//Import vue
import { ref, onMounted } from "vue";

//Import composant
import Total from "./stats/Total.vue";
import Moyenne from "./stats/Moyenne.vue";

//import interface / API
import type { Relever } from "./script/Relever.ts";
import { requeteAPI } from "./script/APIrequest.ts";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

// Variables réactives pour stocker les données découpées
const labelsDates = ref<string[]>([]);
const dataPuffs = ref<number[]>([]);
const dataVolume = ref<number[]>([]);
const dataClope = ref<number[]>([]);
const dataNico = ref<number[]>([]);

const chargerHistorique = async () => {
    const data = await requeteAPI("historique_releves", { id: id.value });

    if (data.resultat) {
        const historique = data.resultat as Relever[];

        labelsDates.value = historique.map((r) => r.date_releve);
        dataPuffs.value = historique.map((r) => r.puffs);
        dataVolume.value = historique.map((r) => r.volume_ml);
        dataClope.value = historique.map((r) => r.cigarettes_fumees);
        dataNico.value = historique.map((r) => r.taux_nicotine);
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
    />
</template>
