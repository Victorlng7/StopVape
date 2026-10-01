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
        <input
            class="inputSign"
            type="email"
            v-model="mail"
            placeholder="E-Mail"
        />
        <input
            class="inputSign"
            type="password"
            v-model="mdp"
            placeholder="Mot de passe"
        />
    </div>

    <div>
        <button class="Sign" @click="VerifierInfo">Se Connecter</button>
    </div>
</template>
