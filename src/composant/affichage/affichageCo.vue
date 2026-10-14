<script setup lang="ts">
//Import vue
import { ref, watch } from "vue";

//Import composants
import AjouterValeur from "../divers/AjouterValeur.vue";
import creeGout from "../divers/creeGout.vue";
import graphiques from "../graphiques/graphiques.vue";
import Stats from "../stats/Stats.vue";

//Creation IdUser
const iduser = ref();

//Import
const props = defineProps(["affichage", "id"]);

//Assignation quand le props arrive
watch(
    () => props.id,
    (newId) => {
        console.log("nouvelle valeur id affichage : ", newId);
        iduser.value = newId;
    },
    { deep: true, immediate: true },
);

const parametre = ref(false);

function parametretrue() {
    if (parametre.value) {
        parametre.value = false;
    } else parametre.value = true;
}

function deco() {
    console.log("Deconnection");

    props.affichage[2] = false;
    props.affichage[0] = true;
}
</script>

<template>
    <main class="dashboard-page">
        <header class="dashboard-heading">
            <div class="flex">
                <div>
                    <p class="dashboard-eyebrow">ESPACE PERSONNEL</p>
                    <h1>Votre suivi</h1>
                    <p
                        >Vos habitudes, vos données et vos progrès au même
                        endroit.</p
                    >
                </div>

                <div>
                    <button @click="parametretrue">Paramètres</button>
                    <div v-if="parametre">
                        <button @click="deco">Se déconnecter</button>
                    </div>
                </div>
            </div>
        </header>

        <div class="mainConnection">
            <section class="dashboard-panel recipeComp">
                <creeGout />
            </section>

            <section class="dashboard-panel entryComp">
                <AjouterValeur :idUser="iduser" />
            </section>

            <section class="dashboard-panel graphiqueComp">
                <h2>Évolution</h2>
                <graphiques :idUser="iduser" />
            </section>

            <section class="dashboard-panel statsComp">
                <h2>Vos statistiques</h2>
                <Stats :id-user="iduser" />
            </section>
        </div>
    </main>
</template>

<style scoped></style>
