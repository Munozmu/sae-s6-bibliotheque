import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Categories } from '../models/categories';

@Injectable({
  providedIn: 'root'
})
export class CategoriesService {

  private apiUrl: string = environment.apiUrl;

  constructor(
    private http: HttpClient
  ) { }

  getAllCategories() {
    return this.http.get<Categories[]>(`${this.apiUrl}/categories`);
  }

  getCategory(id: number) {
    return this.http.get<Categories>(`${this.apiUrl}/categories/${id}`);
  }
}
