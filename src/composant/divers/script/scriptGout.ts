export function calculerProportionArome(
    niveauArome: number,
    intensiteArome: number,
): number {
    switch (niveauArome) {
        case 1:
            return appliquerIntensiteArome(0.01, intensiteArome);
        case 2:
            return appliquerIntensiteArome(0.0225, intensiteArome);
        case 3:
            return appliquerIntensiteArome(0.035, intensiteArome);
        case 4:
            return appliquerIntensiteArome(0.04, intensiteArome);
        case 5:
            return appliquerIntensiteArome(0.0475, intensiteArome);
        default:
            throw new Error(
                "Le niveau d'arôme doit être compris entre 1 et 5.",
            );
    }
}

function appliquerIntensiteArome(proportion: number, intensiteArome: number): number {
    switch (intensiteArome) {
        case 5:
            return proportion * 6;
        case 10:
            return proportion * 3;
        case 15:
            return proportion * 2;
        default:
            throw new Error("Cette intensité d'arôme n'est pas disponible.");
    }
}

export function calculerVolumeBooster(
    volumeFinalMl: number,
    tauxNicotineMgMl: number,
): number {
    return (volumeFinalMl * tauxNicotineMgMl) / 20;
}
