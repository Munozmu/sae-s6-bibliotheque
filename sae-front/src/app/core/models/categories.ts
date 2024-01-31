import { Book } from "./book";

export interface Categories {
  id: number;
  nom: string;
  description: string;
  livres?: Book[];
}
