<script setup lang="ts">
import { ref } from "vue";
import { requeteAPI } from "./script/APIrequest";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

const relevePuff = ref(0);
const volume_ml = ref(0);
const tauxNico = ref(0);
const clopesmoke = ref(0);
const manque = ref(0);
const depense = ref(0);

const envoyerReleve = async () => {
    const reponse = await requeteAPI("ajouter_releve", {
        id: id.value,
        relevePuff: relevePuff.value,
        volume_ml: volume_ml.value,
        tauxNico: tauxNico.value,
        clopesmoke: clopesmoke.value,
        manque: manque.value,
        depense: depense.value,
    });

    if (reponse.resultat) {
        console.log("Données enregistrées");
    }
};

function display() {
    console.log("id :", id.value);
    console.log("relevePuff :", relevePuff.value);
    console.log("volume_ml :", volume_ml.value);
    console.log("tauxNico :", tauxNico.value);
    console.log("clopesmoke :", clopesmoke.value);
    console.log("manque :", manque.value);
    console.log("depense :", depense.value);
}
</script>

<template>
    <div>
        <input type="number" v-model="relevePuff" />
        <input type="number" v-model="volume_ml" />
        <input type="number" v-model="tauxNico" />
        <input type="number" v-model="clopesmoke" />
        <input type="number" v-model="depense" />
        <select name="manque" v-model="manque">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>

    <button @click="display">display</button>

    <button @click="envoyerReleve">ajouter</button>
</template>

<style scoped></style>
