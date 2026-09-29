<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "@/composant/script/APIrequest";

const mail = ref("");
const mdp = ref("");

async function VerifierInfo() {
    const connection = await requeteAPI("connection_utilisateur", {
        mail: mail.value,
        password: mdp.value,
    });

    if (connection.resultat) {
        console.log(connection.resultat);
    }
}
</script>

<template>
    <div>
        <input type="text" v-model="mail" placeholder="Mail" />
        <input type="text" v-model="mdp" placeholder="PassWord" />
    </div>

    <div>
        <button @click="VerifierInfo">Se Connecter</button>
    </div>
</template>
