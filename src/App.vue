<script setup lang="ts">
import { onMounted, ref } from "vue";
import { requeteAPI, type AuthenticatedUser } from "./composant/APIrequest";
import { viderDonneeGraph } from "./composant/graphiques/scripts/useGraph";
import { viderDonneeStats } from "./composant/stats/scripts/useStats";

//Import Style
import "./assets/root.css";
import "./assets/styleGlobale.css";
import "./assets/grid.css";
import "./assets/dashboard.css";

//Import composants
import utilisateur from "./composant/login/utilisateur.vue";
import affichageCo from "./composant/affichage/affichageCo.vue";
import AffichageDeco from "./composant/affichage/affichageDeco.vue";

const utilisateurConnecte = ref<AuthenticatedUser | null>(null);
const page = ref<"accueil" | "auth">("accueil");
const chargementSession = ref(true);
const erreurSession = ref("");
const erreurDeconnexion = ref("");

onMounted(async () => {
    try {
        const reponse = await requeteAPI("session");
        utilisateurConnecte.value = reponse.utilisateur ?? null;
    } catch {
        erreurSession.value = "Impossible de vérifier votre session.";
    } finally {
        chargementSession.value = false;
    }
});

function ouvrirAuthentification() {
    page.value = "auth";
}

function connecter(utilisateur: AuthenticatedUser) {
    utilisateurConnecte.value = utilisateur;
}

async function deconnecter() {
    erreurDeconnexion.value = "";
    try {
        const reponse = await requeteAPI("deconnection_utilisateur");
        if (reponse.success) {
            viderDonneeGraph();
            viderDonneeStats();
            utilisateurConnecte.value = null;
            page.value = "accueil";
        } else {
            erreurDeconnexion.value = reponse.erreur ?? "Déconnexion impossible.";
        }
    } catch {
        erreurDeconnexion.value = "Impossible de contacter le serveur.";
    }
}
</script>

<template>
    <p v-if="chargementSession">Chargement de votre session…</p>
    <p v-else-if="erreurSession">{{ erreurSession }}</p>
    <affichageCo
        v-else-if="utilisateurConnecte"
        :user="utilisateurConnecte"
        :logout-error="erreurDeconnexion"
        @logout="deconnecter"
    />
    <utilisateur
        v-else-if="page === 'auth'"
        @login="connecter"
    />
    <AffichageDeco v-else @open-auth="ouvrirAuthentification" />
</template>

<style scoped></style>
