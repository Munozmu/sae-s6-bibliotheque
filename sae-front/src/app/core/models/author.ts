export interface Author {
  id: number;
  nom: string;
  prenom?: string;
  dateNaissance?: Date;
  dateDeces?: Date;
  nationalite?: string;
  photo?: string;
  description?: string;
}
