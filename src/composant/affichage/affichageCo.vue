<script setup lang="ts">
import { ref } from "vue";
import type { AuthenticatedUser } from "../APIrequest";

//Import composants
import AjouterValeur from "../divers/AjouterValeur.vue";
import creeGout from "../divers/creeGout.vue";
import graphiques from "../graphiques/graphiques.vue";
import Stats from "../stats/Stats.vue";

const props = defineProps<{
    user: AuthenticatedUser;
    logoutError?: string;
}>();
const emit = defineEmits<{ logout: [] }>();

const parametre = ref(false);

function parametretrue() {
    parametre.value = !parametre.value;
}

function deco() {
    emit("logout");
}
</script>

<template>
    <main class="dashboard-page">
        <header class="dashboard-heading">
            <div class="flex">
                <div>
                    <p class="dashboard-eyebrow">ESPACE PERSONNEL</p>
                    <h1>Bonjour {{ props.user.prenom }}</h1>
                    <p
                        >Vos habitudes, vos données et vos progrès au même
                        endroit.</p
                    >
                </div>

                <div>
                    <button @click="parametretrue">Paramètres</button>
                    <div v-if="parametre">
                        <button @click="deco">Se déconnecter</button>
                    </div>
                </div>
            </div>
        </header>
        <p v-if="props.logoutError" role="alert">
            {{ props.logoutError }}
        </p>

        <div class="mainConnection">
            <section class="dashboard-panel recipeComp">
                <creeGout />
            </section>

            <section class="dashboard-panel entryComp">
                <AjouterValeur />
            </section>

            <section class="dashboard-panel graphiqueComp">
                <h2>Évolution</h2>
                <graphiques />
            </section>

            <section class="dashboard-panel statsComp">
                <h2>Vos statistiques</h2>
                <Stats />
            </section>
        </div>
    </main>
</template>

<style scoped></style>
