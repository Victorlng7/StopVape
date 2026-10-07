<script setup lang="ts">
//Import Vue
import { ref } from "vue";

//Import Type/Classes
import {
    calculerProportionArome,
    calculerVolumeBooster,
} from "./script/scriptGout.ts";

const volumesDisponiblesMl = [50, 100, 200, 500];
const volumeFinalMl = ref(50);

const tauxNicotineDisponiblesMgMl = [0, 1.5, 3, 6, 12];
const tauxNicotineSouhaiteMgMl = ref(0);

const profilsArome = [
    "Très leger",
    "Leger",
    "Balancé",
    "Sucré",
    "Intense",
] as const;
type ProfilArome = (typeof profilsArome)[number];
const profilArome = ref<ProfilArome>("Balancé");
const niveauParProfil: Record<ProfilArome, number> = {
    "Très leger": 1,
    Leger: 2,
    Balancé: 3,
    Sucré: 4,
    Intense: 5,
};

const intensitesArome = [5, 10, 15];
const intensiteArome = ref(5);

const volumeBoosterMl = ref(0);
const volumeAromeMl = ref(0);
const volumeBaseMl = ref(0);

function calculerRecette() {
    volumeBoosterMl.value = calculerVolumeBooster(
        volumeFinalMl.value,
        tauxNicotineSouhaiteMgMl.value,
    );
    volumeAromeMl.value =
        calculerProportionArome(
            niveauParProfil[profilArome.value],
            intensiteArome.value,
        ) * volumeFinalMl.value;
    volumeBaseMl.value =
        volumeFinalMl.value - volumeBoosterMl.value - volumeAromeMl.value;
}
</script>

<template>
    <div class="container">
        <div class="classInput" id="qte">
            <span>Quel volume final voulez-vous (ml) ?</span>
            <select v-model="volumeFinalMl">
                <option
                    v-for="option in volumesDisponiblesMl"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>
        <div class="classInput" id="nico">
            <span>Quel taux de nicotine voulez-vous (mg/ml) ?</span>
            <select v-model="tauxNicotineSouhaiteMgMl">
                <option
                    v-for="option in tauxNicotineDisponiblesMgMl"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>
        <div class="classInput" id="darome">
            <span>Profil d'arôme</span>
            <select v-model="profilArome">
                <option
                    v-for="option in profilsArome"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>

        <div class="classInput" id="iarome">
            <span>Intensité de l'arôme</span>
            <select v-model="intensiteArome">
                <option
                    v-for="option in intensitesArome"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>

        <div class="classInput" id="validation">
            <span>Vous avez fini ?</span>
            <button @click="calculerRecette">Préparer votre e-liquide</button>
        </div>
        <div class="classInput" id="result">
            <p>Base : {{ volumeBaseMl.toFixed(2) }} ml</p>
            <p>Booster : {{ volumeBoosterMl.toFixed(2) }} ml</p>
            <p>Arôme : {{ volumeAromeMl.toFixed(2) }} ml</p>
        </div>
    </div>
</template>

<style scoped>
.container {
    margin: 0;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(4, 1fr);
    gap: 8px;
}

#darome {
    grid-column: span 2 / span 2;
}

#iarome {
    grid-column: span 2 / span 2;
    grid-column-start: 1;
    grid-row-start: 2;
}

#validation {
    grid-column: span 2 / span 2;
    grid-column-start: 3;
    grid-row-start: 2;
}

#qte {
    grid-column-start: 3;
    grid-row-start: 1;
}

#nico {
    grid-column-start: 4;
    grid-row-start: 1;
}

#result {
    grid-column: span 2 / span 2;
    grid-row: span 2 / span 2;
    grid-column-start: 2;
    grid-row-start: 3;
}
.classInput {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.classInput select {
    text-align: center;
}
</style>
