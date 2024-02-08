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

    return this.http.post(`${this.apiUrl}/reservationss`, { dateResa: formattedDate, reserverPar: '/api/adherents/' + userId, lier: '/api/livres/' + bookId });
  }

  cancelReservation(reservationId: number) {
    console.log('reservationId:', reservationId);
    return this.http.delete(`${this.apiUrl}/reservationss/${reservationId}`);
  }
}
