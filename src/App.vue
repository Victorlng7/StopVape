<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import Style
import "./css/root.css";

//Import composants

import affichageCo from "./composant/affichage/affichageCo.vue";
// import AffichageDeco from "./composant/affichage/affichageDeco.vue";

// Variable hardcodé iduser
const iduser = ref(1);
</script>

<template>
    <affichageCo />
</template>

<style scoped></style>
