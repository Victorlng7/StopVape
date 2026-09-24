export function creerDate(str: string): Date {
    const [jour, mois, annee] = str.split("-").map(Number);

    return new Date(Number(annee), Number(mois), Number(jour));
}
