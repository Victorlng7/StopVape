<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import composants
import AjouterValeur from "./composant/divers/AjouterValeur.vue";
import creeGout from "./composant/divers/creeGout.vue";
import utilisateur from "./composant/login/utilisateur.vue";
import graphiques from "./composant/graphiques/graphiques.vue";
import Stats from "./composant/stats/Stats.vue";

// Variable hardcodé iduser
const iduser = ref(1);
</script>

<template>
    <utilisateur />
    <creeGout />

    <AjouterValeur :idUser="iduser" />
    <graphiques :idUser="iduser" />
    <Stats :id-user="iduser" />
</template>

<style scoped></style>
