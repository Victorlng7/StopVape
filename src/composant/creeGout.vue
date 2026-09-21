<script setup lang="ts">
//Import Vue
import { ref } from "vue";

//Import page
import inputGout from "./sousComposant/inputGout.vue";
import afficherGout from "./sousComposant/afficherGout.vue";

//Import Type/Classes
import type { Gout } from "./sousComposant/script/InterfaceGout.ts";

const qte = ref(0);
const nico = ref(0);
const intensiteGout = ref(3);

const parmGout = ref<Number[]>([]);

function CreeGout(value: Gout) {
    parmGout.value = [];

    qte.value = value.dose;
    nico.value = value.doseNico;

    switch (value.intensiteGout) {
        case "Très leger":
            intensiteGout.value = 1;
            break;
        case "Leger":
            intensiteGout.value = 2;
            break;
        case "Balancé":
            intensiteGout.value = 3;
            break;
        case "Sucré":
            intensiteGout.value = 4;
            break;
        case "Intense":
            intensiteGout.value = 5;
            break;
    }

    parmGout.value.push(qte.value, nico.value, intensiteGout.value);
}
</script>

<template>
    <inputGout @gout="CreeGout" />
    <afficherGout :parm-gout="parmGout" />
</template>

<style scoped></style>
