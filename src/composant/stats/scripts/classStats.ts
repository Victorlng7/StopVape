import { addTab } from "./addTab.ts";
import { creerDate } from "./creerDate.ts";

export class stats {
    public label: string[];
    public puff: number[];
    public nico: number[];
    public clope: number[];
    public volume: number[];
    public argent: number[];

    constructor() {
        this.label = [];
        this.puff = [];
        this.nico = [];
        this.clope = [];
        this.volume = [];
        this.argent = [];
    }
    //Get values

    get totalArgent(): number {
        return addTab(this.argent);
    }
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

            return difference / (1000 * 60 * 60 * 24) + 1;
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
