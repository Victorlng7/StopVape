import { specChar, numChar } from "./char.ts";

export function isMdp(mdp: string): boolean {
    if (mdp.length >= 10) {
        let bonSpec = false;
        let bonNum = false;

        specChar.forEach((element) => {
            if (mdp.includes(element)) bonSpec = true;
        });
        numChar.forEach((element) => {
            if (mdp.includes(element.toString())) bonNum = true;
        });

        if (bonNum && bonSpec) return true;
    }
    return false;
}
