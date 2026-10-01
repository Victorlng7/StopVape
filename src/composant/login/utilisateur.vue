<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import style
import App from "@/App.vue";
import "./assets/styleUser.css";

//Import composants
import pageSingUp from "./pageSingUp.vue";
import pageSignIn from "./pageSignIn.vue";

const vSi = ref(true);
const vSu = ref(false);

function changerV(){
    if(vSi.value){
        vSi.value = false
        vSu.value = true
    }else if(vSu.value){
        vSu.value = false
        vSi.value = true
    }else{
        throw new Error("Vsi & Vsu sont false")
    }
    
}
</script>

<template>
    <div class="blur blur1"></div>
    <div class="blur blur2"></div>

    <main>
        <h1 class="titlePage" v-if="vSi">Se connecter</h1>
        <h1 class="titlePage" v-if="vSu">S'inscrire</h1>
        <article>
            <div v-if="vSi">
                <pageSignIn />
            </div>
            <div v-if="vSu">
                <pageSingUp />
            </div>
        </article>
        <section>
            <div v-if="vSu">
                <button class="btnChange" @click="changerV">J'ai déjà un compte</button>
            </div>
            <div v-if="vSi"">
                <button class="btnChange" @click="changerV">Je n'ai pas de compte</button>
            </div>
        </section>
    </main>
</template>
