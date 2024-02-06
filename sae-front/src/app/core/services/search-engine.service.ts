import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Observable } from 'rxjs';
import { Book } from '../models/book';

@Injectable({
  providedIn: 'root'
})
export class SearchEngineService {

  private apiUrl: string = environment.apiUrl;

  constructor(
    private http: HttpClient
  ) { }

  searchBooks(keywords: string, category: string, author: string, lang: string, anneeMin: number, anneeMax: number): Observable<Book[]> {
    if (anneeMin === null || anneeMin === undefined) {
      anneeMin = 0;
    }
    if (anneeMax === null || anneeMax === undefined) {
      anneeMax = 9999;
    }

    let params = new HttpParams();
    params = params.set('keywords', keywords);
    params = params.set('anneeMin', anneeMin.toString());
    params = params.set('anneeMax', anneeMax.toString());

    if (category) {
      params = params.set('category', category);
    }
    if (author) {
      params = params.set('author', author);
    }
    if (lang) {
      params = params.set('lang', lang);
    }

    return this.http.get<Book[]>(`${this.apiUrl}/search`, { params });
  }
}
