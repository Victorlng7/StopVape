<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import Style
import "./css/root.css";

//Import composants
import utilisateur from "./composant/login/utilisateur.vue";
// import affichageCo from "./composant/affichage/affichageCo.vue";
// import AffichageDeco from "./composant/affichage/affichageDeco.vue";

// Variable hardcodé iduser
const iduser = ref(31);
</script>

<template>
    <utilisateur />
</template>

<style scoped></style>
