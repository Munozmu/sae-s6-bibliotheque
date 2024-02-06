import { Injectable } from '@angular/core';
import { Book } from '../models/book';
import { Observable, map, of } from 'rxjs';
import { Author } from '../models/author';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { AuthService } from '../auth/auth.service';
import { BookStatus } from '../models/bookStatus';

@Injectable({
  providedIn: 'root'
})
export class BookService {

  private apiUrl: string = environment.apiUrl;

  constructor(
    private http: HttpClient,
    private authService: AuthService
  ) { }

  getAllBooks(): Observable<Book[]> {
    return this.http.get<Book[]>(`${this.apiUrl}/livres`);
  }

  getBookById(id: number): Observable<Book> {
    return this.http.get<Book>(`${this.apiUrl}/livres/${id}`);
  }

  getAllCategories(): Observable<string[]> {
    return this.http.get<string[]>(`${this.apiUrl}/categories`);
  }

  getAllAuthors(): Observable<Author[]> {
    return this.http.get<Author[]>(`${this.apiUrl}/auteurs`);
  }


  /**
   * Check if a book can be booked or not
   * @param book Book to check
   * @returns true if the book is avalaible
   */
  isBookAvailable(book: Book): boolean {
    const isBookBorrowed = book.emprunts && book.emprunts.length > 0 && book.emprunts[book.emprunts.length - 1].enCours;
    const isBookReserved = book.reservations && book.reservations.length > 0;

    return !(isBookBorrowed || isBookReserved);
  }


  /**
   * Check if a book can be reserved of borowed
   */
  getBookStatus(book: Book): Observable<BookStatus> {
    let userId: number;

    return this.authService.currentUser$.pipe(
      map(user => {
        if (user) {
          userId = user.id;

          let avalaible = true;
          let borrowed = false;
          let reserved = false;
          let reservedByUser = false;
          let borrowedByUser = false;

          // Si le livre est réservé
          if (book.reservations && book.reservations.length > 0) {
            reserved = true;
            if (book.reservations[0].reserver_par?.id === userId) {
              reservedByUser = true;
            }
          }

          // Si le livre est emprunté
          if (book.emprunts && book.emprunts.length > 0 && book.emprunts[book.emprunts.length - 1].enCours) {
            borrowed = true;
            if (book.emprunts[book.emprunts.length - 1].adherent?.id === userId) {
              borrowedByUser = true;
            }
          }

          avalaible = !(borrowed || reserved);

          return {
            avalaible,
            borrowed,
            reserved,
            reservedByUser,
            borrowedByUser
          };
        } else {
          return {
            avalaible: false,
            borrowed: false,
            reserved: false,
            reservedByUser: false,
            borrowedByUser: false
          };
        }
      })
    );
  }



}
