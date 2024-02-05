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
  ) { }

  // Create global BehaviorSubject to share the authentication state
  private currentUserSubject: BehaviorSubject<Adherent> = new BehaviorSubject<Adherent>({} as Adherent);
  currentUser$: Observable<Adherent | null> = this.currentUserSubject.asObservable();

  login(credentials: { username: string, password: string }) {

    this.http.post(`${this.apiURL}/login`, credentials).subscribe(
      (response: any) => {
        this.isAuthenticated = true;
        this.setToken(response);
        this.refreshCurrentUser();
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
        this.currentUserSubject.next(user);
      }
    );
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
