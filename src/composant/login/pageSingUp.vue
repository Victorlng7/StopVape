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
const idUser = ref();

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
        console.log(mail.value, mdp.value, nom.value, prenom.value);
    }
}

const ajouterMembre = async () => {
    //Creation de l'utilisateur même si l'email n'est pas vérifier
    const reponse = await requeteAPI("creer_utilisateur", {
        nom: nom.value,
        prenom: prenom.value,
        email: mail.value.toLowerCase(),
        mot_de_passe: mdp.value,
    });

    //Si l'utilisateur est créer
    if (reponse.resultat) {
        //On récupère son ID pour le code de vérification
        const id = await requeteAPI("recuperer_id", {
            email: mail.value.toLowerCase(),
        });

        //Si on a son ID
        if (id.resultat) {
            idUser.value = id.resultat[0].id;

            //Creation du code de vérification
            const verif = await requeteAPI("verif_mail", {
                id: idUser.value,
            });

            //Si tout est bon on met inscrit a true
            //(pour afficher la partie pour vérifier le code)
            if (verif.resultat) {
                inscrit.value = true;
            }
        }
    }
};

const CodeVerif = ref("");
const verifier = ref(false);

//Quand on valide le code de vérification
const verifCode = async () => {
    const reponse = await requeteAPI("verif_code", {
        id: idUser.value,
        code: CodeVerif.value,
    });

    //Si success
    if (reponse.success) {
        verifier.value = true;
    }
};
</script>

<template>
    <div v-if="!inscrit">
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
        </div>
    </div>
    <div v-if="inscrit">
        <p>Un code de vérification à été envoyé à l'adresse {{ mail }}</p>

        <input
            class="inputSign"
            type="text"
            v-model="CodeVerif"
            placeholder="Nom"
            autocomplete="family-name"
        />

        <button class="Sign" @click="verifCode">Vérifier votre compte</button>

        <p v-if="verifier"
            >Vous êtes désormai inscrit ! Vous pouvez vous connecter</p
        >
    </div>
</template>
