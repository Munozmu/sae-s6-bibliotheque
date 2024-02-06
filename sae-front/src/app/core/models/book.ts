import { Author } from "./author";

export interface Book {
  id: number;
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
  reservations?: {
    reserver_par?: {
      id?: number;
    };
  }[];
  auteurs: Author[];
  resume?: string;
}
