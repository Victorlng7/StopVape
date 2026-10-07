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
const props = defineProps(["id"]);

//Assignation quand le props arrive
watch(
    () => props.id,
    (newId) => {
        console.log("nouvelle valeur id affichage : ", newId);
        iduser.value = newId;
    },
    { deep: true, immediate: true },
);
</script>

<template>
    <main class="dashboard-page">
        <header class="dashboard-heading">
            <p class="dashboard-eyebrow">ESPACE PERSONNEL</p>
            <h1>Votre suivi</h1>
            <p>Vos habitudes, vos données et vos progrès au même endroit.</p>
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
