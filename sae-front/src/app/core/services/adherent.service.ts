import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Adherent } from '../models/adherent';

@Injectable({
  providedIn: 'root'
})
export class AdherentService {

  private apiURL = environment.apiUrl;

  constructor(
    private http: HttpClient
  ) { }

  getAdherent(id: number) {
    return this.http.get<Adherent>(`${this.apiURL}/adherents/${id}`);
  }
}
