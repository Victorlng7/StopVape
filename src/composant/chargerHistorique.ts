import { requeteAPI } from "./APIrequest.ts";
import type { Relever } from "./Relever.ts";

export async function chargerHistorique(): Promise<Relever[] | void> {
    const data = await requeteAPI("historique_releves");

    if (Array.isArray(data.resultat)) {
        return data.resultat as Relever[];
    }
}
