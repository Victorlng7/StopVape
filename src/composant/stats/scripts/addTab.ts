export function addTab(tab: number[]): number {
    let somme = 0;

    tab.forEach((element) => {
        somme += element;
    });

    return somme;
}
