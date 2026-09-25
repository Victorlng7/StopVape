export function switchArome(v: number, intensite: number): number {
    switch (v) {
        case 1:
            return switchIntensite(0.01, intensite);
        case 2:
            return switchArome(0.0225, intensite);
        case 3:
            return switchArome(0.035, intensite);
        case 4:
            return switchArome(0.04, intensite);
        case 5:
            return switchArome(0.0475, intensite);
        default:
            throw new Error("V se trouve entre 1 et 5 pas plus ni moins");
    }
}

function switchIntensite(v: number, intensite: number): number {
    switch (intensite) {
        case 5:
            return v * 6;
        case 10:
            return v * 3;
        case 15:
            return v * 2;
        default:
            throw new Error("l'intensité voulu est indisponible");
    }
}

export function switchNico(volume: number, cible: number): number {
    return (volume * cible) / 20;
}
