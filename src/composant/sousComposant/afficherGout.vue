<script setup lang="ts">
//Import vue
import { watch, ref } from "vue";

//import Fonction
import { switchNico } from "./script/switchnico";
import { switchArome } from "./script/switchGout";

const props = defineProps(["parmGout"]);
const parm: number[] = [];

const doseNico = ref(0);
const doseGout = ref(0);
const doseBase = ref(0);

watch(
    () => props.parmGout,
    (newV) => {
        newV.forEach((elt: number, idx: number) => {
            parm[idx] = elt;
        });
        calculerGout();
    },
);

function calculerGout() {
    const vol = parm[0];
    const nicotarget = parm[1];
    const intensGout = parm[2];

    console.log(vol, nicotarget, intensGout);

    doseNico.value = switchNico(Number(vol), Number(nicotarget));
    doseGout.value = switchArome(Number(intensGout)) * Number(vol);
    doseBase.value =
        Number(vol) - (Number(doseGout.value) + Number(doseNico.value));
}
</script>

<template>
    <p>{{ doseBase }} {{ doseNico }} {{ doseGout }} </p>
</template>

<style scoped></style>
