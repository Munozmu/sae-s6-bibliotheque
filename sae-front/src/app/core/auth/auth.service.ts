import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, map, of, switchMap } from 'rxjs';
import { AdherentService } from '../services/adherent.service';
import { Adherent } from '../models/adherent';
import { AccessToken } from '../models/accesstoken';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private isAuthenticated = false;
  private apiURL = environment.apiUrl;

  constructor(
    private http: HttpClient,
    private adherentService: AdherentService
  ) {

    if (!this.isLoggedIn()) {
      this.currentUserSubject.next(null);
      console.log('currentUserSubject', this.currentUserSubject.getValue());
    } else {
      this.refreshCurrentUser();
      console.log(this.isLoggedIn());
    }
  }

  // Create global BehaviorSubject to share the authentication state
  private currentUserSubject: BehaviorSubject<Adherent | null> = new BehaviorSubject<Adherent | null>({} as Adherent);
  currentUser$: Observable<Adherent | null> = this.currentUserSubject.asObservable();

  login(credentials: { username: string, password: string }) {

    this.http.post(`${this.apiURL}/login`, credentials).subscribe(
      (response: any) => {
        // Succès de la requête
        this.isAuthenticated = true;
        this.setToken(response);
        this.refreshCurrentUser();
      },
      (error) => {
        // Gestion des erreurs
        console.error('Une erreur est survenue lors de la connexion : ', error);
        this.removeToken();
        this.refreshCurrentUser();
        // Vous pouvez afficher un message d'erreur à l'utilisateur ou prendre d'autres mesures nécessaires
      },
      () => {
        // Cette fonction sera appelée lorsque l'observable sera complété
        console.log('La requête de connexion est terminée.');
      }
    );
  }


  logout() {
    this.isAuthenticated = false;
    this.removeToken();
  }

  refreshCurrentUser(): void {
    this.getCurrentUser().subscribe(
      (user) => {
        console.log('refreshCurrentUser', user);
        this.currentUserSubject.next(user);
      }
    );
  }

  getCurrentUser(): Observable<Adherent> {
    return of(this.getToken()).pipe(
      switchMap((token) => {
        if (token) {
          this.isAuthenticated = true;
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
  setToken(token: AccessToken): void {
    localStorage.setItem('access_token', JSON.stringify(token));
  }

  getToken(): string | null {
    return localStorage.getItem('access_token');
  }

  removeToken(): void {
    localStorage.removeItem('access_token');
  }

  isLoggedIn(): boolean {
    return this.isAuthenticated;
  }




}
