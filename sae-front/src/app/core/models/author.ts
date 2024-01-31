export interface Author {
  id: number;
  nom: string;
  prenom?: string;
  dateNaiss?: Date;
  dateDeces?: Date;
  nationalite?: string;
  photo?: string;
  description?: string;
}
