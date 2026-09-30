<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "../APIrequest";

const id = ref();
const mail = ref("");
const mdp = ref("");

async function VerifierInfo() {
    if (mail.value && mdp.value) {
        console.log("mail & mdp rempli");

        const connection = await requeteAPI("connection_utilisateur", {
            mail: mail.value.toLowerCase(),
            password: mdp.value,
        });
        if (connection.resultat) {
            id.value = connection.resultat.id;
        }
    }
}
</script>

<template>
    <div>
        <input type="email" v-model="mail" placeholder="Mail" />
        <input type="password" v-model="mdp" placeholder="PassWord" />
    </div>

    <div>
        <button @click="VerifierInfo">Se Connecter</button>
    </div>
</template>
