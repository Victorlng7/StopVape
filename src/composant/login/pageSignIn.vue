<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "../APIrequest";

const id = ref();
const mail = ref("");
const mdp = ref("");

const emit = defineEmits(["id", "connecter"]);

async function VerifierInfo() {
    if (mail.value && mdp.value) {
        const connection = await requeteAPI("connection_utilisateur", {
            mail: mail.value.toLowerCase(),
            password: mdp.value,
        });
        if (connection.resultat) {
            emit("id", connection.resultat.id, "connecter", true);
        }
    }
}
</script>

<template>
    <div class="auth-fields">
        <input
            class="inputSign"
            type="email"
            v-model="mail"
            placeholder="E-Mail"
            autocomplete="email"
        />
        <input
            class="inputSign"
            type="password"
            v-model="mdp"
            placeholder="Mot de passe"
            autocomplete="current-password"
        />
    </div>

    <div class="auth-submit">
        <button class="Sign" @click="VerifierInfo">Se Connecter</button>
    </div>
</template>
