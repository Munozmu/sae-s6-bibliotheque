import { Adherent } from "./adherent";

export interface AccessToken {
  token: string;
  user: Adherent;
}
