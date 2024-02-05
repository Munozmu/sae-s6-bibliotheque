import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ReservationsService {

  private apiUrl: string = environment.apiUrl;

  constructor(
    private http: HttpClient
  ) { }

  postReservation(bookId: number, userId: number) {

    const currentDate = new Date();
    const formattedDate: string = currentDate.toISOString();

    return this.http.post(`${this.apiUrl}/reservations`, { dateResa: formattedDate, reserver_par: '/api/livres/' + bookId, lier: '/api/adherents/' + userId });
  }
}
