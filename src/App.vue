<script setup lang="ts">
//Improt vue
import { ref } from "vue";

//Import Style
import "./assets/root.css";
import "./assets/styleGlobale.css";
import "./assets/grid.css";

//Import composants
import utilisateur from "./composant/login/utilisateur.vue";
import affichageCo from "./composant/affichage/affichageCo.vue";
import AffichageDeco from "./composant/affichage/affichageDeco.vue";

// Variable hardcodé iduser
const iduser = ref();

//Variable de quoi afficher
const affichage = ref([true, false, false]);

//Fonction changer l'id user
function changerId(id: number) {
    console.log("Changement d'id au niveau de app : ", id);
    iduser.value = id;
}
</script>

<template>
    <affichageDeco :affichage="affichage" v-if="affichage[0]" />
    <utilisateur :affichage="affichage" @id="changerId" v-if="affichage[1]" />
    <affichageCo :affichage="affichage" :id="iduser" v-if="affichage[2]" />
</template>

<style scoped></style>
