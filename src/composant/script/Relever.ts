export interface Relever {
    id: number;
    user_id: number;
    date_releve: string;
    puffs: number;
    volume_ml: number; // TS gère les DECIMAL SQL comme des 'number'
    taux_nicotine: number;
    cigarettes_fumees: number;
    niveau_manque: number;
    depenses_euros: number;
}
