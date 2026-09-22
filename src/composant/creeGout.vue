<script setup lang="ts">
//Import Vue
import { ref } from "vue";

//Import Type/Classes
import { switchArome, switchNico } from "./script/scriptGout.ts";

//Input gout
const quantiteGout = ref(50);
const optionGout = [50, 100, 200, 500];

const doseNico = ref(0);
const optionNico = [0, 1.5, 3, 6, 12];

const doseArome = ref("Balancé");
const optionArome = ["Très leger", "Leger", "Balancé", "Sucré", "Intense"];

//Affichage
const qte = ref(0);
const nico = ref(0);
const intensiteGout = ref(3);

function calculerGout(
    vol: number,
    nicotarget: number,
    concentrationGout: number,
) {
    console.log(vol, nicotarget, concentrationGout);

    nico.value = switchNico(vol, nicotarget);
    intensiteGout.value = switchArome(concentrationGout) * vol;
    qte.value = vol - (intensiteGout.value - nico.value);
}

function CreeGout() {
    const vol = quantiteGout.value;
    const nicotarget = doseNico.value;
    let concentrationGout = 3;

    switch (doseArome.value) {
        case "Très leger":
            concentrationGout = 1;
            break;
        case "Leger":
            concentrationGout = 2;
            break;
        case "Balancé":
            concentrationGout = 3;
            break;
        case "Sucré":
            concentrationGout = 4;
            break;
        case "Intense":
            concentrationGout = 5;
            break;
    }

    calculerGout(vol, nicotarget, concentrationGout);
}
</script>

<template>
    <h1>Creation de votre gout</h1>

    <div class="container">
        <div class="classInput" id="qte">
            <span>Quel quantité voulez vous ?</span>
            <select v-model="quantiteGout">
                <option
                    v-for="option in optionGout"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>
        <div class="classInput" id="nico">
            <span>Quel dose de nicotine (mg/ml)</span>
            <select v-model="doseNico">
                <option
                    v-for="option in optionNico"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>
        <div class="classInput" id="arome">
            <span>Intensité du gout</span>
            <select v-model="doseArome">
                <option
                    v-for="option in optionArome"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </div>

        <div class="classInput" id="validation">
            <span>Vous avez fini ?</span>
            <button @click="CreeGout">Preparer votre E-liquide</button>
        </div>
    </div>

    <p>{{ qte }} {{ doseNico }} {{ intensiteGout }} </p>
</template>

<style scoped>
.container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 8px;
}
.classInput {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.classInput select {
    text-align: center;
}

#arome {
    grid-column: span 2 / span 2;
}
#validation {
    grid-column: span 2 / span 2;
    grid-column-start: 2;
    grid-row-start: 2;
}
</style>
