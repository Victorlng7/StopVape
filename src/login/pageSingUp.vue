<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "@/composant/script/APIrequest";
import { isMdp } from "./scripts/isMdp";
import { IsMail } from "./scripts/verifMail";
import type { Utilisateur } from "./scripts/interfaceUser";

const nom = ref("Doe");
const prenom = ref("John");
const mail = ref("johndoe@example.com");
const mdp = ref("");

async function VerifierInfo() {
    if (
        IsMail(mail.value) &&
        /*isMdp(mdp.value) &&*/ nom.value &&
        prenom.value
    ) {
        console.log("Info OK");

        const mailValide = await requeteAPI("verifier_utilisateurs", {
            mail: mail.value,
        });
        console.log(mailValide.resultat);

        if (mailValide.resultat.0) {
            console.log(mailValide.resultat);
        }

        // if (mailValide.resultat === undefined || mailValide.resultat) {
        //     console.error("Email déjà utilisé");
        //     console.log(mailValide.reponse);
        // } else {
        //     console.log(mailValide.reponse);
        //     ajouterMembre();
        // }
    } else {
        console.error("Une des info saisie est pas ok !");
    }
}

const ajouterMembre = async () => {
    const reponse = await requeteAPI("creer_utilisateur", {
        nom: nom.value,
        prenom: prenom.value,
        email: mail.value,
        mot_de_passe: mdp.value,
    });

    if (reponse.resultat) {
        console.log(reponse.resultat);
    }
};
</script>

<template>
    <div>
        <input type="text" v-model="nom" />
        <input type="text" v-model="prenom" />
        <input type="text" v-model="mail" />
        <input type="text" v-model="mdp" />
    </div>

    <div>
        <button @click="VerifierInfo">VerifierMembreDejala</button>
    </div>
</template>
