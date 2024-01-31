import { Author } from "./author";

export interface Book {
  id: number;
  titre?: string;
  dateSortie?: Date;
  langue?: string;
  photoCouverture?: string;
  auteurs: Author[];
  resume?: string;
}
