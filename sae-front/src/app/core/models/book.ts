import { Author } from "./author";

export interface Book {
  id: number;
  titre?: string;
  dateSortie?: Date;
  langue?: string;
  photoCouverture?: string;
  emprunts?: [
    {
      enCours?: boolean;
    }
  ];
  reservations?: any[];
  auteurs: Author[];
  resume?: string;
}
