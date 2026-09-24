import { addTab } from "./addTab.ts";
import { creerDate } from "./creerDate.ts";

export class stats {
    private label: string[];
    private puff: number[];
    private nico: number[];
    private clope: number[];
    private volume: number[];

    constructor(
        label: string[],
        puff: number[],
        nico: number[],
        clope: number[],
        volume: number[],
    ) {
        this.label = label;
        this.puff = puff;
        this.nico = nico;
        this.clope = clope;
        this.volume = volume;
    }

    //Get values Vanilla

    get labels(): string[] {
        return this.label;
    }

    get puffs(): number[] {
        return this.puff;
    }

    get nicos(): number[] {
        return this.nico;
    }

    get clopes(): number[] {
        return this.clope;
    }

    get volumes(): number[] {
        return this.volume;
    }

    //Get values Autre

    get totalPuff(): number {
        return addTab(this.puff);
    }
    get totalClope(): number {
        return addTab(this.clope);
    }
    get totalVolume(): number {
        return addTab(this.volume);
    }
    get tempsSevrage(): number {
        const lastIndex = this.label.length - 1;

        if (this.label[0] && this.label[lastIndex]) {
            const date1 = creerDate(this.label[0]);
            const date2 = creerDate(this.label[lastIndex]);

            const difference = date2.getTime() - date1.getTime();

            return difference / (1000 * 60 * 60 * 24);
        } else return 0;
    }

    //Set values
    setLabel(t: string[]) {
        this.label = t;
    }

    setPuff(t: number[]) {
        this.puff = t;
    }

    setNico(t: number[]) {
        this.nico = t;
    }

    setClope(t: number[]) {
        this.clope = t;
    }

    setVolume(t: number[]) {
        this.volume = t;
    }
}
