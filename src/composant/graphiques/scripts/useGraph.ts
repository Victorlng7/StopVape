import { ref } from "vue";
import { chargerHistorique } from "../../chargerHistorique.ts";

// On exporte toutes les variables réactives
export const labelsDates = ref<string[]>([]);
export const dataPuffs = ref<number[]>([]);
export const dataVolume = ref<number[]>([]);
export const dataClope = ref<number[]>([]);
export const dataNico = ref<number[]>([]);
export const dataManque = ref<number[]>([]); // Ajouté ici
export const dataArgent = ref<number[]>([]);

// On exporte la fonction de chargement
export async function chargerDonneeGraph(idUser: number) {
    const historique = await chargerHistorique(idUser);

    if (historique) {
        labelsDates.value = historique.map((r: any) => r.date_releve);
        dataPuffs.value = historique.map((r: any) => r.puffs);
        dataVolume.value = historique.map((r: any) => r.volume_ml);
        dataClope.value = historique.map((r: any) => r.cigarettes_fumees);
        dataNico.value = historique.map((r: any) => r.taux_nicotine);
        dataManque.value = historique.map((r: any) => r.niveau_manque); // Correction ici !
        dataArgent.value = historique.map((r: any) => r.depenses_euros);
    }
}
