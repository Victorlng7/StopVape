<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import composants
import AjouterValeur from "./composant/AjouterValeur.vue";
import CreeGout from "./composant/creeGout.vue";
import utilisateur from "./composant/utilisateur.vue";
import Graphiques from "./composant/graphiques.vue";

// Variable hardcodé iduser
const iduser = ref(1);
</script>

<template>
    <!-- <creeGout /> -->
    <!-- <utilisateur/> -->
    <AjouterValeur :idUser="iduser" />
    <Graphiques :idUser="iduser" />
</template>

<style scoped></style>
