<script setup lang="ts">
//Import vue
import { ref } from "vue";
import type { AuthenticatedUser } from "../APIrequest";

//import Fonction/interface
import { requeteAPI } from "../APIrequest";

const mail = ref("");
const mdp = ref("");
const erreur = ref("");
const chargement = ref(false);

const emit = defineEmits<{
    login: [user: AuthenticatedUser];
}>();

async function VerifierInfo() {
    erreur.value = "";
    if (mail.value.trim() && mdp.value) {
        chargement.value = true;
        try {
            const connection = await requeteAPI("connection_utilisateur", {
                mail: mail.value.trim().toLowerCase(),
                password: mdp.value,
            });
            if (connection.utilisateur) {
                emit("login", connection.utilisateur);
            } else {
                erreur.value = connection.erreur ?? "Connexion impossible.";
            }
        } catch {
            erreur.value = "Le serveur est indisponible. Réessayez plus tard.";
        } finally {
            chargement.value = false;
        }
    } else {
        erreur.value = "Saisissez votre adresse e-mail et votre mot de passe.";
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
        <p v-if="erreur" role="alert">{{ erreur }}</p>
        <button class="Sign" :disabled="chargement" @click="VerifierInfo">
            {{ chargement ? "Connexion..." : "Se Connecter" }}
        </button>
    </div>
</template>
