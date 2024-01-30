import { Injectable } from '@angular/core';
import { Book } from '../models/book';
import { Observable, of } from 'rxjs';
import { Author } from '../models/author';

@Injectable({
  providedIn: 'root'
})
export class BookService {

  constructor() { }

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
