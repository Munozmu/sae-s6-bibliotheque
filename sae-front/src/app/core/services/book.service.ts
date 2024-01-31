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
    //TODO: implement this
    return of([]);
  }

  getAllCategories(): Observable<string[]> {
    return of(['cat1', 'cat2', 'cat3']);
  }

  getAllAuthors(): Observable<Author[]> {
    return of([
      { id: 1, nom: 'Hugo' },
      { id: 2, nom: 'Zola' },
      { id: 3, nom: 'Maupassant' },
    ]);
  }


}
