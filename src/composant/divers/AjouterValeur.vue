<script setup lang="ts">
import { ref } from "vue";
import { requeteAPI } from "../APIrequest.ts";
import { calculerNbPuff } from "./script/calculerNbPuff.ts";
import type { Relever } from "../graphiques/scripts/Relever.ts";

const props = defineProps(["idUser"]);
const id = ref(props.idUser);

const relevePuff = ref(0);
const volume_ml = ref(0);
const tauxNico = ref(0);
const clopesmoke = ref(0);
const manque = ref(0);
const depense = ref(0);

const idSuivi = ref(0);

const envoyerReleve = async () => {
    if (idSuivi.value === 0) {
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
            alert("Information ajouté avec succes");
        }
    } else {
        const reponse1 = await requeteAPI("supprimer_releve", {
            id: idSuivi.value,
        });

        if (reponse1.resultat) {
            const puffsCalcules = await calculerNbPuff(
                relevePuff.value,
                id.value,
            );

            const reponse2 = await requeteAPI("ajouter_releve", {
                id: id.value,
                puffBrute: relevePuff.value,
                relevePuff: puffsCalcules,
                volume_ml: volume_ml.value,
                tauxNico: tauxNico.value,
                clopesmoke: clopesmoke.value,
                manque: manque.value,
                depense: depense.value,
            });
            if (reponse2.resultat) {
                alert("Information modifié avec succes");
            }
        }

        idSuivi.value = 0;
    }

    viderZoneSaisie();
};

function viderZoneSaisie() {
    const tabSaisie = [
        relevePuff,
        volume_ml,
        tauxNico,
        clopesmoke,
        manque,
        depense,
    ];

    tabSaisie.forEach((element) => {
        element.value = 0;
    });
}

const chargerLastRel = async () => {
    const data = await requeteAPI("dernier_releves", { id: id.value });

    if (data.resultat) {
        const historique = data.resultat as Relever[];

        const releve = historique[historique.length - 1];

        relevePuff.value = releve?.releve_puff_brut ?? 0;
        volume_ml.value = releve?.volume_ml ?? 0;
        tauxNico.value = releve?.taux_nicotine ?? 0;
        clopesmoke.value = releve?.cigarettes_fumees ?? 0;
        manque.value = releve?.niveau_manque ?? 0;
        depense.value = releve?.depenses_euros ?? 0;

        idSuivi.value = releve?.id ?? 0;
    }
};
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
    <div class="btnAjtContainder">
        <button @click="envoyerReleve">Ajouter</button>
        <button @click="chargerLastRel">Modifier dernier relevé</button>
    </div>
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
.btnAjtContainder {
    display: flex;
    justify-content: flex-end;
}
</style>
