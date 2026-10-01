export class moyenne {
    public argentTotal: number;
    public dureeTotal: number;
    public totalPuff: number;
    public totalVolume: number;

    constructor() {
        this.argentTotal = 0;
        this.dureeTotal = 0;
        this.totalPuff = 0;
        this.totalVolume = 0;
    }

    //Setters

    setVolume(v: number) {
        this.totalVolume = v;
    }
    setPuff(v: number) {
        this.totalPuff = v;
    }
    setArgent(v: number) {
        this.argentTotal = v;
    }
    setDuree(v: number) {
        this.dureeTotal = v;
    }

    //Getters values

    get argentJour(): number {
        return this.argentTotal / this.dureeTotal;
    }
    get puffJour(): number {
        return this.totalPuff / this.dureeTotal;
    }
    get puffVolume(): number {
        return this.totalPuff / this.totalVolume;
    }
}
