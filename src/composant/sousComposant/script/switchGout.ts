export function switchArome(v: number): number {
    switch (v) {
        case 1:
            return 0.06;
        case 2:
            return 0.09;
        case 3:
            return 0.12;
        case 4:
            return 0.16;
        case 5:
            return 0.2;
        default:
            throw new Error("V se trouve entre 1 et 5 pas plus ni moins");
    }
}
