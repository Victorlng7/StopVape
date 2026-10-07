<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import style
import App from "@/App.vue";
import "./assets/styleUser.css";

//Import composants
import pageSingUp from "./pageSingUp.vue";
import pageSignIn from "./pageSignIn.vue";

const props = defineProps(["affichage"]);
const emit = defineEmits(["id"]);

const vSi = ref(true);
const vSu = ref(false);

function changerV() {
    if (vSi.value) {
        vSi.value = false;
        vSu.value = true;
    } else if (vSu.value) {
        vSu.value = false;
        vSi.value = true;
    } else {
        throw new Error("Vsi & Vsu sont false");
    }
}

function changerId(id: number) {
    console.log("Id récupérer ", id);
    emit("id", id);
    console.log("changerconnection");
    props.affichage[1] = false;
    props.affichage[2] = true;
}
</script>

<template>
    <div class="auth-page">
        <main class="auth-card">
            <p class="auth-eyebrow">STOPSMOKE · ESPACE PERSONNEL</p>
            <h1 class="titlePage" v-if="vSi">Se connecter</h1>
            <h1 class="titlePage" v-if="vSu">S'inscrire</h1>
            <p class="auth-intro" v-if="vSi"
                >Retrouvez votre suivi et vos progrès.</p
            >
            <p class="auth-intro" v-if="vSu"
                >Créez votre espace de suivi personnel.</p
            >
            <article class="auth-form">
                <div v-if="vSi">
                    <pageSignIn @id="changerId" />
                </div>
                <div v-if="vSu">
                    <pageSingUp />
                </div>
            </article>
            <section class="auth-switch">
                <div v-if="vSu">
                    <span>Vous avez déjà un compte ?</span>
                    <button class="btnChange" @click="changerV"
                        >Se connecter</button
                    >
                </div>
                <div v-if="vSi">
                    <span>Vous découvrez StopSmoke ?</span>
                    <button class="btnChange" @click="changerV"
                        >Créer un compte</button
                    >
                </div>
            </section>
        </main>
    </div>
</template>
