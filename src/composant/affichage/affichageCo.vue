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

<template class="mainConnection">
    <creeGout />

    <AjouterValeur :idUser="iduser" />
    <graphiques :idUser="iduser" class="graphiqueComp" />
    <Stats :id-user="iduser" class="statsComp" />
</template>

<style scoped></style>
