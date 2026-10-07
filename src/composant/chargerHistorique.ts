import { requeteAPI } from "./APIrequest.ts";
import type { Relever } from "./Relever.ts";

export async function chargerHistorique(id: number): Promise<Relever[] | void> {
    const data = await requeteAPI("historique_releves", { id: id });

    if (data.resultat) {
        return data.resultat as Relever[];
    }
}
