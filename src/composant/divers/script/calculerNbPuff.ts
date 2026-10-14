import { requeteAPI } from "../../APIrequest.ts";
import type { Relever } from "../../Relever.ts";

export async function calculerNbPuff(
    puffBrut: number,
): Promise<number> {
    const data = await requeteAPI("historique_releves");

    if (Array.isArray(data.resultat)) {
        const historique = data.resultat as Relever[];
        const dernierPuffBrut = historique.map((r) => r.releve_puff_brut);

        if (dernierPuffBrut && dernierPuffBrut.length > 0) {
            const derniereValeur = dernierPuffBrut[dernierPuffBrut.length - 1];

            if (derniereValeur !== undefined && derniereValeur !== null) {
                const ancienBrut = Number(derniereValeur);

                if (puffBrut >= ancienBrut) {
                    return puffBrut - ancienBrut;
                } else {
                    return 10000 - ancienBrut + puffBrut;
                }
            }
        }
    }

    return 0;
}
