export interface Adherent {
  id: number;
  dateAdhesion: Date;
  nom: string;
  prenom: string;
  dateNaiss: Date;
  email: string;
  adressePostale: string;
  numTel: number;
  photo: string;
  reservations: {
    dateResa: Date;
    id: number;
    lier: {
      titre: string;
      photoCouverture: string;
      id: number;
    }
  }[];
}
