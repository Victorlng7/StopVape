<script setup lang="ts">
//Import vue
import { ref } from "vue";

//Import composants
import AjouterValeur from "../divers/AjouterValeur.vue";
import creeGout from "../divers/creeGout.vue";
import graphiques from "../graphiques/graphiques.vue";
import Stats from "../stats/Stats.vue";

const iduser = ref(31);
</script>

<template>
    <creeGout />

    <AjouterValeur :idUser="iduser" />
    <graphiques :idUser="iduser" />
    <Stats :id-user="iduser" />
</template>

<style scoped></style>
