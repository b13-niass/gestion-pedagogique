
export interface IClient{
    adresse?:string;
    create_at?:string;
    email?:string;
    id?:number;
    nom?:string;
    password?:string;
    photo?:string;
    prenom?:string;
    telephone?:string;
    update_at?:string;
}

export interface IClasse{
    id?:number;
    libelle?:string;
    filiere_id?:number;
    niveau_id?:number;
    created_at?:string;
    updated_at?:string;
}

export interface IListCoursLoadData {
     id?:number;
     intitule?:string;
     heureGlobale?:string;
     professeur_id?:number;
     semestreannee_id?:number;
     module_id?:number;
     created_at?:string;
     updated_at?:string;
     module_name?:string;
     semestre_name?:string;
     annee_name?:string;
     classes?: IClasse[];
}

export interface IListSessionsLoadData {
    id?:number;
    cour_id?: number;
    created_at?: string;
    date_session?: string;
    etat_avancement?: string;
    etat_global?: string;
    heureDebut?: string;
    heureFin?: string;
    module_name?: string;
    presence?: string;
    justificatif?: boolean;
    salle_id?: string;
    updated_at?: string;
}