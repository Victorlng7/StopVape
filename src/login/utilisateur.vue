<script setup lang="ts">
//import vue
import { ref } from "vue";

//Import composants
import pageSingUp from "./pageSingUp.vue";

//Inport type/fonction
import type { Utilisateur } from "./scripts/interfaceUser";
import { requeteAPI } from "@/composant/script/APIrequest";
</script>

<template>
    <pageSingUp />
</template>
