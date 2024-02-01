import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable, of, switchMap } from 'rxjs';
import { AdherentService } from '../services/adherent.service';
import { Adherent } from '../models/adherent';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private isAuthenticated = false;
  private apiURL = environment.apiUrl;

  constructor(
    private http: HttpClient,
    private adherentService: AdherentService
  ) { }

  // login(credentials: { username: string, password: string }) {
  login() {
    this.isAuthenticated = true;
    return this.http.post(`${this.apiURL}/logout`, {});
  }

  logout() {
    this.isAuthenticated = false;
  }

  getIsAuthenticated(): boolean {
    return this.isAuthenticated;
  }

  getCurrentUser(): Observable<Adherent> {
    return of(this.getToken()).pipe(
      switchMap((token) => {
        if (token) {
          const userId = JSON.parse(token).user.id;
          return this.adherentService.getAdherent(userId);
        } else {
          // Si le token est absent, vous pouvez retourner une valeur par défaut ou générer une erreur selon vos besoins.
          return of({} as Adherent);
        }
      })
    );
  }

  // LOCAL TOKEN MANAGEMENT
  setToken(token: string): void {
    localStorage.setItem('access_token', JSON.stringify(token));
  }

  getToken(): string | null {
    return localStorage.getItem('access_token');
  }

  removeToken(): void {
    localStorage.removeItem('access_token');
  }




}
