import { Author } from "./author";

export interface Book {
  id: number;
  livreId?: number;
  livre_id?: number;
  titre?: string;
  dateSortie?: Date;
  langue?: string;
  photoCouverture?: string;
  emprunts?: {
    enCours?: boolean;
    adherent?: {
      id?: number;
    };
  }[];
  reservations: {
    id: number;
    reserver_par?: {
      id?: number;
    };
  }[];
  auteurs: Author[];
  auteur_id?: number;
  resume?: string;
  auteurNom?: string;
  auteur_nom?: string;
  prenom?: string;
  auteurPrenom?: string;
  auteurId?: number;
}
