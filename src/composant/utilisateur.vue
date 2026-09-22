<script setup lang="ts">
//import vue
import { ref, onMounted } from "vue";

//Inport type/fonction
import { requeteAPI } from "./script/APIrequest";
import type { Utilisateur } from "./script/interfaceUser";

const nom = ref("Doe");
const prenom = ref("John");
const mail = ref("johndoe@example.com");
const mdp = ref("MyBeautifullPassword");

const utilisateurs = ref<Utilisateur[]>([]);

const chargerDonnees = async () => {
    const data = await requeteAPI("lister_utilisateurs");
    if (data.resultat) {
        utilisateurs.value = data.resultat;
    }
};

onMounted(() => {
    chargerDonnees();
});

const ajouterMembre = async () => {
    const reponse = await requeteAPI("creer_utilisateur", {
        nom: nom.value,
        prenom: prenom.value,
        email: mail.value,
        mot_de_passe: mdp.value,
    });

    if (reponse.resultat) {
        console.log(reponse.resultat);
        chargerDonnees();
    }
};

const supprimerMembre = async (idUtilisateur: number) => {
    await requeteAPI("supprimer_utilisateur", { id: idUtilisateur });
    chargerDonnees();
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
        <button @click="ajouterMembre">Ajouter utilisateur</button>
        <ul>
            <li v-for="user in utilisateurs" :key="user.id">
                {{ user.prenom }} {{ user.nom }}
                <button @click="supprimerMembre(user.id)">❌</button>
            </li>
        </ul>
    </div>
</template>
