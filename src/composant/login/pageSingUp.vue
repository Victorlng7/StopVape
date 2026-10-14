<script setup lang="ts">
//Import vue
import { ref } from "vue";

//import Fonction/interface
import { requeteAPI } from "../APIrequest";
import { isMdp } from "./scripts/isMdp";
import { IsMail } from "./scripts/verifMail";

const nom = ref("");
const prenom = ref("");
const mail = ref("");
const mdp = ref("");

const inscrit = ref(false);
const erreur = ref("");
const chargement = ref(false);

async function VerifierInfo() {
    erreur.value = "";
    if (IsMail(mail.value) && isMdp(mdp.value) && nom.value && prenom.value) {
        await ajouterMembre();
    } else {
        erreur.value = "Vérifiez les informations saisies.";
    }
}

const ajouterMembre = async () => {
    chargement.value = true;
    try {
        const reponse = await requeteAPI("creer_utilisateur", {
            nom: nom.value.trim(),
            prenom: prenom.value.trim(),
            email: mail.value.trim().toLowerCase(),
            mot_de_passe: mdp.value,
        });

        if (reponse.erreur) {
            erreur.value = reponse.erreur;
            return;
        }

        const verification = await requeteAPI("verif_mail");
        if (verification.erreur) {
            erreur.value = verification.erreur;
            return;
        }
        inscrit.value = true;
    } catch {
        erreur.value = "Le serveur est indisponible. Réessayez plus tard.";
    } finally {
        chargement.value = false;
    }
};

const CodeVerif = ref("");
const verifier = ref(false);

//Quand on valide le code de vérification
const verifCode = async () => {
    erreur.value = "";
    chargement.value = true;
    try {
        const reponse = await requeteAPI("verif_code", {
            code: CodeVerif.value,
        });
        if (reponse.success) {
            verifier.value = true;
        } else {
            erreur.value = reponse.erreur ?? "Code de vérification invalide.";
        }
    } catch {
        erreur.value = "Le serveur est indisponible. Réessayez plus tard.";
    } finally {
        chargement.value = false;
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
            <p v-if="erreur" role="alert">{{ erreur }}</p>
            <button class="Sign" :disabled="chargement" @click="VerifierInfo">
                {{ chargement ? "Inscription..." : "S'inscrire" }}
            </button>
        </div>
    </div>
    <div v-if="inscrit">
        <p>Un code de vérification a été demandé pour {{ mail }}</p>

        <input
            class="inputSign"
            type="text"
            v-model="CodeVerif"
            placeholder="Code de vérification"
            autocomplete="one-time-code"
        />

        <p v-if="erreur" role="alert">{{ erreur }}</p>
        <button class="Sign" :disabled="chargement" @click="verifCode">
            Vérifier votre compte
        </button>

        <p v-if="verifier"
            >Vous êtes désormai inscrit ! Vous pouvez vous connecter</p
        >
    </div>
</template>
