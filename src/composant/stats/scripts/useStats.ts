import { ref } from "vue";
import { chargerHistorique } from "../../chargerHistorique.ts";

// 1. On exporte les variables réactives pour qu'elles soient partagées
export const labelsDates = ref<string[]>([]);
export const dataPuffs = ref<number[]>([]);
export const dataVolume = ref<number[]>([]);
export const dataClope = ref<number[]>([]);
export const dataNico = ref<number[]>([]);
export const dataArgent = ref<number[]>([]);

// 2. On exporte la fonction de rechargement
export async function chargerDonneeStats(idUser: number) {
    const historique = await chargerHistorique(idUser);

    if (historique) {
        labelsDates.value = historique.map((r: any) => r.date_releve);
        dataPuffs.value = historique.map((r: any) => r.puffs);
        dataVolume.value = historique.map((r: any) => r.volume_ml);
        dataClope.value = historique.map((r: any) => r.cigarettes_fumees);
        dataNico.value = historique.map((r: any) => r.taux_nicotine);
        dataArgent.value = historique.map((r: any) => r.depenses_euros);
    }
}
