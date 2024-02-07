import { Author } from "./author";

export interface Book {
  id: number;
  livreId?: number;
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
  resume?: string;
  auteurNom?: string;
  auteurPrenom?: string;
  auteurId?: number;
}
