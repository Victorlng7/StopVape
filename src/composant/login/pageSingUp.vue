<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "../APIrequest";
import { isMdp } from "./scripts/isMdp";
import { IsMail } from "./scripts/verifMail";
import type { Utilisateur } from "./scripts/interfaceUser";

const nom = ref("");
const prenom = ref("");
const mail = ref("");
const mdp = ref("");

const inscrit = ref(false);

async function VerifierInfo() {
    if (IsMail(mail.value) && isMdp(mdp.value) && nom.value && prenom.value) {
        console.log("Info OK");

        const mailValide = await requeteAPI("verifier_utilisateurs", {
            mail: mail.value.toLowerCase(),
        });
        console.log(mailValide.resultat);

        if (mailValide.resultat[0]) {
            console.error("Email déjà utilisé");
            console.log(mailValide.reponse);
        } else {
            console.log(mailValide.reponse);
            ajouterMembre();
        }
    } else {
        console.error("Une des info saisie est pas ok !");
    }
}

const ajouterMembre = async () => {
    const reponse = await requeteAPI("creer_utilisateur", {
        nom: nom.value,
        prenom: prenom.value,
        email: mail.value.toLowerCase(),
        mot_de_passe: mdp.value,
    });

    if (reponse.resultat) {
        inscrit.value = true;
    }
};
</script>

<template>
    <div class="auth-fields">
        <div class="flex">
            <input
                class="inputSign"
                type="text"
                v-model="nom"
                placeholder="Nom"
                autocomplete="family-name"
            />
            <input
                class="inputSign"
                type="text"
                v-model="prenom"
                placeholder="Prénom"
                autocomplete="given-name"
            />
        </div>
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
            autocomplete="new-password"
        />
    </div>

    <div class="auth-submit">
        <button class="Sign" @click="VerifierInfo">S'inscrire</button>
        <p v-if="inscrit">Vous êtes inscrit !</p>
    </div>
</template>
