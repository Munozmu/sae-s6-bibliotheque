import { Injectable } from '@angular/core';
import { Book } from '../models/book';
import { Observable, of } from 'rxjs';
import { Author } from '../models/author';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class BookService {

  private apiUrl: string = environment.apiUrl;

  constructor(
    private http: HttpClient
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



}
