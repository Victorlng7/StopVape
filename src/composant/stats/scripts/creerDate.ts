export function creerDate(str: string): Date {
    const [annee, mois, jour] = str.split("-").map(Number);

    return new Date(Number(annee), Number(mois) - 1, Number(jour));
}
