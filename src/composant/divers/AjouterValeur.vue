<script setup lang="ts">
import { ref } from "vue";
import { requeteAPI } from "../script/APIrequest";
import { calculerNbPuff } from "../script/calculerNbPuff";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

const relevePuff = ref(0);
const volume_ml = ref(0);
const tauxNico = ref(0);
const clopesmoke = ref(0);
const manque = ref(0);
const depense = ref(0);

const envoyerReleve = async () => {
    const puffsCalcules = await calculerNbPuff(relevePuff.value, id.value);

    const reponse = await requeteAPI("ajouter_releve", {
        id: id.value,
        puffBrute: relevePuff.value,
        relevePuff: puffsCalcules,
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
    <div class="form-container">
        <div class="form-group">
            <span>Taffes (inscrit sur l'écran de la cigarette)</span>
            <input type="number" v-model="relevePuff" />
        </div>

        <div class="form-group">
            <span>Quantité E-liquide consommé (ml)</span>
            <input type="number" v-model="volume_ml" />
        </div>

        <div class="form-group">
            <span>Taux nicotine (%)</span>
            <input type="number" v-model="tauxNico" />
        </div>

        <div class="form-group">
            <span>Cigarette fumées</span>
            <input type="number" v-model="clopesmoke" />
        </div>

        <div class="form-group">
            <span>Dépenses</span>
            <input type="number" v-model="depense" />
        </div>

        <div class="form-group">
            <span>Niveau manque</span>
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
    </div>
    <button @click="display">display</button>

    <button @click="envoyerReleve">ajouter</button>
</template>

<style scoped>
.form-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 400px;
    margin: auto;
}

.form-group {
    width: 100%;
}

.form-group input,
.form-group select {
    width: 100%;
    box-sizing: border-box;
    padding: 8px;
}
</style>
