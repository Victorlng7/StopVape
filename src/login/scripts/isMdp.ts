export function isMdp(mdp: string): boolean {
    const specChar = ["!", ".", "?", ",", "^", "$", "~", "-", "_"];
    const numChar = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    if (mdp.length > 7) {
        let bonSpec = false;
        let bonNum = false;

        specChar.forEach((element) => {
            if (mdp.includes(element)) bonSpec = true;
        });
        numChar.forEach((element) => {
            if (mdp.includes(element.toString())) bonNum = true;
        });

        if (bonNum && bonSpec) {
            return true;
        }
    }
    return false;
}
