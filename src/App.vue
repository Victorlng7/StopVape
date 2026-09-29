<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import composants
import AjouterValeur from "./composant/AjouterValeur.vue";
import CreeGout from "./composant/creeGout.vue";
import utilisateur from "./login/utilisateur.vue";
import graphiques from "./composant/graphiques.vue";
import Stats from "./composant/Stats.vue";

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
