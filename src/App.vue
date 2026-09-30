<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import Style
import "./css/root.css";

//Import composants
// import AjouterValeur from "./composant/divers/AjouterValeur.vue";
// import creeGout from "./composant/divers/creeGout.vue";
// import utilisateur from "./composant/login/utilisateur.vue";
// import graphiques from "./composant/graphiques/graphiques.vue";
// import Stats from "./composant/stats/Stats.vue";
// import affichageCo from "./composant/affichage/affichageCo.vue";
import AffichageDeco from "./composant/affichage/affichageDeco.vue";

// Variable hardcodé iduser
const iduser = ref(1);
</script>

<template>
    <affichageDeco />

    <!-- <utilisateur />
    <creeGout />

    <AjouterValeur :idUser="iduser" />
    <graphiques :idUser="iduser" />
    <Stats :id-user="iduser" /> -->
</template>

<style scoped></style>
